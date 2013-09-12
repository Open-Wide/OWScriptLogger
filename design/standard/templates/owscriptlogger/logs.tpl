{ezcss_require( 'owscriptlogger.css' )}
{ezscript_require( 'owscriptlogger.js' )}
<div id="logs">
    <div class="box-header">
        <h1 class="context-title">{'Logs'|i18n('owscriptlogger/logs' )}</h1>
        <div class="header-mainline"></div>
    </div>
    <div class="box-content">
        <div class="context-attributes">
            <div class="block">
                <fieldset>
                    <legend>{'Filters'|i18n('owscriptlogger/logs' )}</legend>
                    <label>{'Identifers'|i18n('owscriptlogger/logs' )}</label>
                    {foreach $logger_identifer_list as $logger_identifer}
                        <input type="checkbox" class="identifier_filter" id="identifier_{$logger_identifer}" checked="checked" />{$logger_identifer}
                    {/foreach}
                    <label>{'Date'|i18n('owscriptlogger/logs' )}</label>
                    <input class="date_filter" />
                </fieldset>
            </div>
        </div>
    </div>
    <div class="box-content">
        <div class="context-attributes">
            <div class="block">
                <div class="yui-dt">
                    <form action={'owscriptlogger/logs'|ezurl()} name="LogList" method="post">
                        <table class="log_list">
                            <thead>
                                <tr class="yui-dt-first yui-dt-last" >
                                    <th class="toggle_checkboxes"><div class="yui-dt-liner"><img src={'toggle-button-16x16.gif'|ezimage} alt="{'Invert selection.'|i18n( 'design/admin/class/classlist' )}" title="{'Invert selection.'|i18n( 'design/admin/class/classlist' )}" /></div></th>
                                    <th class="logger_date"><div class="yui-dt-liner">{'Date'|i18n('owscriptlogger/logs' )}</div></th>
                                    <th class="logger_identifier"><div class="yui-dt-liner">{'Identifier'|i18n('owscriptlogger/logs' )}</div></th>
                                    <th class="logger_runtime"><div class="yui-dt-liner">{'Runtime'|i18n('owscriptlogger/logs' )}</div></th>
                                    <th class="logger_memory_usage"><div class="yui-dt-liner">{'Memory usage'|i18n('owscriptlogger/logs' )}</div></th>
                                    <th class="logger_memory_usage_peak"><div class="yui-dt-liner">{'Memory usage peak'|i18n('owscriptlogger/logs' )}</div></th>
                                    <th class="logger_view_log"></th>
                                </tr>
                            </thead>
                            <tbody class="yui-dt-data">
                                {foreach $logger_list as $logger sequence array( 'yui-dt-even', 'yui-dt-odd' ) as $style}
                                    <tr class="{if $index|eq(0)}yui-dt-first{/if} {$style} identifier_{$logger.identifier}">
                                        <td class="yui-dt0-col-checkbox yui-dt-col-checkbox yui-dt-first"><div class="yui-dt-liner"><input type="checkbox" name="DeleteIDArray[]" value="{$logger.id}"></div></td>
                                        <td class="logger_date"><div class="yui-dt-liner">{$logger.date}</div></td>
                                        <td class="logger_identifier"><div class="yui-dt-liner">{$logger.identifier}</div></td>
                                        <td class="logger_runtime"><div class="yui-dt-liner">{$logger.runtime} s</div></td>
                                        <td class="logger_memory_usage"><div class="yui-dt-liner">{$logger.memory_usage|si('byte')}</div></td>
                                        <td class="logger_memory_usage_peak"><div class="yui-dt-liner">{$logger.memory_usage_peak|si('byte')}</div></td>
                                        <td class="logger_view_log"><a href={concat('owscriptlogger/logs/', $logger.id)|ezurl()}>{'View logs'|i18n('owscriptlogger/logs' )}</a></td>
                                    </tr>
                                {/foreach}
                            </tbody>
                        </table>
                        <div class="controlbar">
                            <div class="block">
                                <input class="defaultbutton" type="submit" name="Delete" value="{'Delete'|i18n( 'owscriptlogger/all' )}" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>