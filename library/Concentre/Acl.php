<?php

class Concentre_Acl extends Zend_Acl {
    
    private $dbase;
    protected static $_instance = null;
   
    public static function getInstance(Zend_Db_Adapter_Abstract &$db=null)
    {
        if (null === self::$_instance) {
            self::$_instance = new self($db);
        }

        return self::$_instance;
    }
     
    public function hasAllRolesOf( array &$searchRoles ){
        foreach( $searchRoles as $theRole )
            if( !$this->hasRole( $theRole ) )
                return false;
        return true;
        }
    
    public function __construct( Zend_Db_Adapter_Abstract &$db ){
        $this->dbase = &$db;
        
        // I chose to write the field names into these SQL statements, so that the tables can actually contain more
        // fields than just the ones I need here without producing heavier DB load as neccessary.
        
        /// First: Create all the resources we have.
        $resources = $db->fetchAll( $db->select()->distinct()->from( 'acl_resources', array( 'id', 'parent_id' ) ) );
        
        $resCount  = count( $resources );
        $addCount  = 0;
        
        $allResources = array();
        foreach( $resources as $theRes ){
            $allResources[] = $theRes['id'];
            }
        foreach( $resources as $theRes ){
            if( $theRes['parent_id'] !== null && !in_array( $theRes['parent_id'], $allResources ) ){
                require_once 'Zend/Acl/Exception.php';
                throw new Zend_Acl_Exception(
                    "Resource id '".$theRes['parent_id']."' does not exist"
                    );
                }
            }
        
        while( $resCount > $addCount ){
            foreach( $resources as $theRes ){
                // Check if parent resource (if any) exists
                // Only add if this resource hasn't yet been added and its parent is known, if any
                if( !$this->has( $theRes['id'] ) &&
                    ( $theRes['parent_id'] === null || $this->has( $theRes['parent_id'] ) )
                  ){
                    $this->add( new Zend_Acl_Resource( $theRes['id'] ), $theRes['parent_id'] );
                    $addCount++;
                    }
                }
            }
        
        /// Now create all roles
        $roles = $db->fetchAll(
            $db->select()
            ->from(     array( 'r' => 'acl_roles' ),       array( 'r.id', 'i.parent_id' ) )
            ->joinLeft( array( 'i' => 'acl_inheritance' ), 'r.id=i.child_id'              )
            ->order(    array( 'child_id', 'order' ) )
            );
        
        // Create an array that stores all roles and their parents
        $dbElements = array();
        foreach( $roles as $theRole ){
            if( !isset( $dbElements[ $theRole['id'] ] ) )
                $dbElements[ $theRole['id'] ] = array();
            if( $theRole['parent_id'] !== null )
                $dbElements[ $theRole['id'] ][] = $theRole['parent_id'];
            }
        
        // Now add to the ACL
        $dbElemCount  = count( $dbElements );
        $aclElemCount = 0;
        
        // while there are still elements left to be added
        while( $dbElemCount > $aclElemCount ){
            // Check every element in the db
            foreach( $dbElements as $theDbElem => $theDbElemParents ){
                // Check if a parent is invalid to prevent an infinite loop
                // if the relational DBase works, this shouldn't happen
                foreach( $theDbElemParents as $theParent ){
                    if( !array_key_exists( $theParent, $dbElements ) ){
                        require_once 'Zend/Acl/Exception.php';
                        throw new Zend_Acl_Exception(
                            "Role id '$theParent' does not exist"
                            );
                        }
                    }
                if( !$this->hasRole( $theDbElem ) &&            // if it has not yet been added to the ACL
                    ( empty( $theDbElemParents )  ||            // and no parents exist or
                      $this->hasAllRolesOf( $theDbElemParents ) // we know them all
                    )
                  ){
                    // we can add to ACL
                    $this->addRole( new Zend_Acl_Role( $theDbElem ), $theDbElemParents );
                    $aclElemCount++;
                    }
                }
            }
        
        
        /// Now create all access rules
        $access = $db->fetchAll( $db->select()->from( 'acl_access', array( 'role_id','resource_id','privilege','allow' ) ) );
        
        foreach( $access as $theRule ){
            if( $theRule['allow'] == true )
                $this->allow( $theRule['role_id'], $theRule['resource_id'], $theRule['privilege'] );
            else    $this->deny(  $theRule['role_id'], $theRule['resource_id'], $theRule['privilege'] );
            }
        }
    
    }


?>
