{ezcss_require( 'owscriptlogger.css' )}
{ezscript_require( 'owscriptlogger.js' )}
<div id="logs">
    <div class="context-block">
        <div class="box-header">
            <div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
                <h1 class="context-title">{'Logs'|i18n('owscriptlogger/logs' )}</h1>
                <div class="header-mainline"></div>
            </div></div></div></div></div>
        </div>
        {if $logger_list|count()}
            <form action={'owscriptlogger/logs'|ezurl()} name="LogList" method="post">
                <div class="box-ml"><div class="box-mr">
                    <div class="box-content">
                        <div class="context-toolbar"></div>
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
                                    <label>{'Status'|i18n('owscriptlogger/logs' )}</label>
	                                <input type="checkbox" class="status_filter" id="status_running" checked="checked" />{'running'|i18n('owscriptlogger/logs' )}
	                                <input type="checkbox" class="status_filter" id="status_finished" checked="checked" />{'finished'|i18n('owscriptlogger/logs' )}
	                                <input type="checkbox" class="status_filter" id="status_error" checked="checked" />{'error'|i18n('owscriptlogger/logs' )}
                                    <input type="checkbox" class="status_filter" id="status_manually_stoped" checked="checked" />{'manually_stoped'|i18n('owscriptlogger/logs' )}
                                </fieldset>
                            </div>
                        </div>
                        <div class="context-attributes">
                            <div class="block">
                                <div class="yui-dt">
                                        <table class="list log_list">
                                            <thead>
                                                <tr class="yui-dt-first yui-dt-last" >
                                                    <th class="toggle_checkboxes" rowspan="2"><div class="yui-dt-liner"><img src={'toggle-button-16x16.gif'|ezimage} alt="{'Invert selection.'|i18n( 'design/admin/class/classlist' )}" title="{'Invert selection.'|i18n( 'design/admin/class/classlist' )}" /></div></th>
                                                    <th class="logger_date" rowspan="2"><div class="yui-dt-liner">{'Date'|i18n('owscriptlogger/logs' )}</div></th>
                                                    <th class="logger_identifier" rowspan="2"><div class="yui-dt-liner">{'Identifier'|i18n('owscriptlogger/logs' )}</div></th>
                                                    <th class="logger_runtime" rowspan="2"><div class="yui-dt-liner">{'Runtime'|i18n('owscriptlogger/logs' )}</div></th>
                                                    <th class="logger_memory_usage" rowspan="2"><div class="yui-dt-liner">{'Memory usage'|i18n('owscriptlogger/logs' )}</div></th>
                                                    <th class="logger_memory_usage_peak" rowspan="2"><div class="yui-dt-liner">{'Memory usage peak'|i18n('owscriptlogger/logs' )}</div></th>
                                                    <th class="logger_logs_count" colspan="3"><div class="yui-dt-liner">{'Logs count'|i18n('owscriptlogger/logs' )}</div></th>
                                                    <th class="logger_status" rowspan="2"><div class="yui-dt-liner">{'Status'|i18n('owscriptlogger/logs' )}</div></th>
                                                    <th class="logger_view_log" rowspan="2"></th>
                                                </tr>
                                                <tr>
                                                    <th class="logger_notice_count"><div class="yui-dt-liner">{'Notice'|i18n('owscriptlogger/all' )}</div></th>
                                                    <th class="logger_warning_count"><div class="yui-dt-liner">{'Warning'|i18n('owscriptlogger/all' )}</div></th>
                                                    <th class="logger_error_count"><div class="yui-dt-liner">{'Error'|i18n('owscriptlogger/all' )}</div></th>
                                                </tr>
                                            </thead>
                                            <tbody class="yui-dt-data">
                                                {foreach $logger_list as $logger sequence array( 'yui-dt-even', 'yui-dt-odd' ) as $style}
                                                    <tr class="{if $index|eq(0)}yui-dt-first{/if} {$style} identifier_{$logger.identifier} status_{$logger.status}">
                                                        <td class="yui-dt0-col-checkbox yui-dt-col-checkbox yui-dt-first"><div class="yui-dt-liner"><input type="checkbox" name="DeleteIDArray[]" value="{$logger.id}"></div></td>
                                                        <td class="logger_date"><div class="yui-dt-liner">{$logger.date}</div></td>
                                                        <td class="logger_identifier"><div class="yui-dt-liner">{$logger.identifier}</div></td>
                                                        <td class="logger_runtime"><div class="yui-dt-liner">{if $logger.runtime}{$logger.runtime} s{/if}</div></td>
                                                        <td class="logger_memory_usage"><div class="yui-dt-liner">{if $logger.memory_usage}{$logger.memory_usage|si('byte')}{/if}</div></td>
                                                        <td class="logger_memory_usage_peak"><div class="yui-dt-liner">{if $logger.memory_usage_peak}{$logger.memory_usage_peak|si('byte')}{/if}</div></td>
                                                        <td class="logger_notice_count"><div class="yui-dt-liner">{$logger.notice_count}</div></td>
                                                        <td class="logger_warning_count"><div class="yui-dt-liner">{$logger.warning_count}</div></td>
                                                        <td class="logger_error_count"><div class="yui-dt-liner">{$logger.error_count}</div></td>
                                                        <td class="logger_status"><div class="yui-dt-liner">{$logger.status|i18n('owscriptlogger/logs' )}</div></td>
                                                        <td class="logger_view_log"><a href={concat('owscriptlogger/logs/', $logger.id)|ezurl()}>{'View logs'|i18n('owscriptlogger/logs' )}</a></td>
                                                    </tr>
                                                {/foreach}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="controlbar">
                        <div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br"><div class="block">
                            <div class="controlbar">
                                <div class="block">
                                    <input class="defaultbutton" type="submit" name="Delete" value="{'Delete'|i18n( 'owscriptlogger/all' )}" />
                                </div>
                            </div>
                        </div></div></div></div></div></div>
                    </div>
                </div></div>
            </form>
        {else}
            <div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">
                <div class="box-content">
                    <div class="block">
                        {'No data'|i18n('owscriptlogger/logs' )}
                    </div>
                </div>
            </div></div></div></div></div></div>
        {/if}
    </div>
</div>