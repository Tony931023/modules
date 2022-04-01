<?php

class Status extends MX_Controller
{
	public function view()
	{
		// Perform ajax call to refresh if expired
		if($this->cache->hasExpired("online_*", "/online_([0-9]*)\.cache$/")
		&& $this->cache->hasExpired("isOnline_*", "/isOnline_([0-9]*)\.cache$/"))
		{
			// Prepare data
			$data = array(
						"module" => "sidebox_status",
						"image_path" => $this->template->image_path
					);

			// Load the template file and format
			$out = $this->template->loadPage("ajax.tpl", $data);
		}
		else
		{
			// Load realm objects
			$realms = $this->realms->getRealms();

            // DEBUG: Get Count Players
            $statdata = array();
            for ($i = 0; $i < 10; $i++) $statdata[$i] = array(0, 0, 0, 0);
            foreach ($realms as $realm)
            {
                foreach($realm->getCharacters()->getCharacters(columns("characters", array("account", "race", "class", "online"), $realm->getId()), "account > 0") as $char)
                {
                    $r = $char['race'];
                    $idy = ($char['online'] - 1) * (-1);
                    if($r == 1 || $r == 3 || $r == 4 || $r == 7 || $r == 11) $idx = 0;  // Alianza
                    else $idx = 2;                                                      // Horda
                    switch($char['class']) {
                        case 1: // Guerrero
                            $statdata[0][$idy + $idx]++;
                            break;
                        case 2: // Paladin
                            $statdata[1][$idy + $idx]++;
                            break;
                        case 3: // Cazador
                            $statdata[2][$idy + $idx]++;
                            break;
                        case 4: // Picaro
                            $statdata[3][$idy + $idx]++;
                            break;
                        case 5: // Sacerdote
                            $statdata[4][$idy + $idx]++;
                            break;
                        case 6: // DK
                            $statdata[5][$idy + $idx]++;
                            break;
                        case 7: // Chaman
                            $statdata[6][$idy + $idx]++;
                            break;
                        case 8: // Mago
                            $statdata[7][$idy + $idx]++;
                            break;
                        case 9: // Brujo
                            $statdata[8][$idy + $idx]++;
                            break;
                        case 11: // Druida
                            $statdata[9][$idy + $idx]++;
                            break;
                    }
                }      
            }  
                        
			// Prepare data
			$data = array(
						"module" => "sidebox_status", 
						"realms" => $realms,
						"statdata" => $statdata,
						"realmlist" => $this->config->item('realmlist')
					);

			// Load the template file and format
			$out = $this->template->loadPage("status.tpl", $data);
		}

		return $out;
	}
}
