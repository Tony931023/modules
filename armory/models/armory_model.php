<?php

class Armory_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();	
	}
	
	public function findItem($searchString = "", $realmId = 1)
	{
		//Connect to the world database
		$world_database = $this->realms->getRealm($realmId)->getWorld();
		$world_database->connect();
		
		//Get the connection and run a query
		if($this->config->item('translate_items_name')){
			$itl_locale = $this->config->item('translate_items_name_locale');
			$itl_table = $this->config->item('translate_items_name_locale_table');
			$itl_id_field = $this->config->item('translate_items_name_locale_id_field');
			$itl_locale_field = $this->config->item('translate_items_name_locale_field');
			$itl_name_field = $this->config->item('translate_items_name_locale_name_field');
			
			$sql_fields = columns("item_template", array("entry", "ItemLevel", "RequiredLevel", "InventoryType", "Quality", "class", "subclass"), $realmId).", T.".$itl_name_field." AS ".column("item_template", "name", false, $realmId);
			$sql_tables = table("item_template", $realmId).", ".$itl_table." AS T";
			$sql_where = "T.".$itl_id_field." = ".column("item_template", "entry", false, $realmId)." AND T.".$itl_locale_field." = '".$itl_locale."' AND ";
			$query = $world_database->getConnection()->query("SELECT ".$sql_fields." FROM ".$sql_tables." WHERE ".$sql_where."UPPER(T.".$itl_name_field.") LIKE ? ORDER BY ".column("item_template", "ItemLevel", false, $realmId)." DESC", array('%'.strtoupper($searchString).'%'));
		}else{
			$query = $world_database->getConnection()->query("SELECT ".columns("item_template", array("entry", "name", "ItemLevel", "RequiredLevel", "InventoryType", "Quality", "class", "subclass"), $realmId)." FROM ".table("item_template", $realmId)." WHERE UPPER(".column("item_template", "name", false, $realmId).") LIKE ? ORDER BY ".column("item_template", "ItemLevel", false, $realmId)." DESC", array('%'.strtoupper($searchString).'%'));
		}

		if($query->num_rows() > 0)
		{
			$row = $query->result_array();
			return $row;
		}
		else
		{
			return false;
		}
	}

	public function findGuild($searchString = "", $realmId = 1)
	{
		//Connect to the character database		
		$character_database = $this->realms->getRealm($realmId)->getCharacters();
		$character_database->connect();
		
		//Get the connection and run a query
		$query = $character_database->getConnection()->query(query("find_guilds", $realmId), array('%'.$searchString.'%'));

		if($query->num_rows() > 0)
		{
			$row = $query->result_array();
			
			return $row;
		}
		else
		{
			return false;
		}
	}
	
	public function findCharacter($searchString = "", $realmId = 1)
	{
		//Connect to the character database		
		$character_database = $this->realms->getRealm($realmId)->getCharacters();
		$character_database->connect();
		
		//Get the connection and run a query
		$query = $character_database->getConnection()->query("SELECT ".columns("characters", array("guid", "name", "race", "gender", "class", "level"), $realmId)." FROM ".table("characters", $realmId)." WHERE UPPER(".column("characters", "name", false, $realmId).") LIKE ? ORDER BY ".column("characters", "level", false, $realmId)." DESC", array('%'.strtoupper($searchString).'%'));

		if($query->num_rows() > 0)
		{
			$row = $query->result_array();

			return $row;
		}
		else
		{
			return false;
		}
	}
}
