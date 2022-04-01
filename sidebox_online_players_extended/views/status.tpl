{foreach from=$realms item=realm}
	<div class="realm">
		<div class="realm_online">
			{if $realm->isOnline()}
                {if $show_uptime}
                    <span data-tip="Uptime" class="uptime-count">
                        {$uptimes[$realm->getId()]}
                    </span>
                {/if}
            {else}
                Offline
            {/if}
        </div>
        {$realm->getName()}
        {if $realm->isOnline()}
            ({$realm->getOnline()})
		{/if}
        <div class="realm-bar-wrapper">
            <div class="horde-icon" data-tip="Horde: {$realm->getPercentage("horde")} %"></div>
           <!-- <div class="realm_bar">
                {if $realm->isOnline()}
                    <div data-tip="Horde: {$realm->getPercentage('horde')} %" class="realm_bar_fill horde" style="width:{$realm->getPercentage('horde')}%; height: {$bar_height} !important">
                    </div>
                    <div data-tip="Alliance: {$realm->getPercentage('alliance')} %" class="realm_bar_fill alliance" style="width:{$realm->getPercentage('alliance')}%; height: {$bar_height} !important">
                    </div>
                {/if}
            </div>
            <div class="alliance-icon" data-tip="Alliance: {$realm->getPercentage('alliance')} %"></div>
        </div>



		
			Other values, for designers:

			$realm->getOnline("horde")
			$realm->getPercentage("horde")

			$realm->getOnline("alliance")
			$realm->getPercentage("alliance")

		-->

	</div>
{/foreach}
<div id="realmlist">set realmlist {$realmlist}</div>

<script>
    Tooltip.refresh();
</script>
