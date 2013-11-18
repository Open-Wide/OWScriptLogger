{ezcss_require( 'owscriptlogger.css' )}
<div id="scripts">
    <div class="context-block">
        <div class="box-header">
            <div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
                <h1 class="context-title">{'Scripts'|i18n('owscriptlogger/scripts' )}</h1>
                <div class="header-mainline"></div>
            </div></div></div></div></div>
        </div>
        {if $script_list|count()}
                <div class="box-ml"><div class="box-mr">
                    <div class="box-content">
                        <div class="context-toolbar"></div>
                        <div class="context-attributes">
                            <div class="block">
                                <div class="yui-dt">
                                        <table class="list log_list">
                                            <thead>
                                                <tr class="yui-dt-first yui-dt-last" >
                                                    <th class="script_identifier"><div class="yui-dt-liner">{'Identifier'|i18n('owscriptlogger/scripts' )}</div></th>
                                                    <th class="script_config"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="yui-dt-data">
                                                {foreach $script_list as $script sequence array( 'yui-dt-even', 'yui-dt-odd' ) as $style}
                                                    <tr class="{if $index|eq(0)}yui-dt-first{/if} {$style} identifier_{$script.identifier} status_{$script.status}">
                                                        <td class="script_identifier"><div class="yui-dt-liner">{$script.identifier}</div></td>
                                                        <td class="script_config"><a href={concat('owscriptlogger/scripts/', $script.identifier)|ezurl()}>{'Configure'|i18n('owscriptlogger/scripts' )}</a></td>
                                                    </tr>
                                                {/foreach}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div></div>
                    <div class="controlbar">
                        <div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br"><div class="block">
                            <div class="controlbar">
                                <div class="block">
                                </div>
                            </div>
                        </div></div></div></div></div></div>
                    </div>
                </div></div>
        {else}
            <div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">
                <div class="box-content">
                    <div class="block">
                        {'No data'|i18n('owscriptlogger/scripts' )}
                    </div>
                </div>
            </div></div></div></div></div></div>
        {/if}
    </div>
</div>