{ezcss_require( 'owscriptlogger.css' )}
{ezscript_require( 'owscriptlogger.js' )}
<div id="log_details">
    <div class="box-header">
        <h1 class="context-title">{'Logs'|i18n('owscriptlogger/logs' )}</h1>
        <div class="header-mainline"></div>
    </div>
    <div class="box-content">
        <div class="context-attributes">
            <div class="block">
                <fieldset>
                    <legend>{'Filters'|i18n('owscriptlogger/logs' )}</legend>
                    <label>{'Level'|i18n('owscriptlogger/logs' )}</label>
                    <input type="checkbox" class="level_filter" id="level_notice" checked="checked" />{'Notice'|i18n('owscriptlogger/logs' )}
                    <input type="checkbox" class="level_filter" id="level_warning" checked="checked" />{'Warning'|i18n('owscriptlogger/logs' )}
                    <input type="checkbox" class="level_filter" id="level_error" checked="checked" />{'Error'|i18n('owscriptlogger/logs' )}
                    <label>{'Actions'|i18n('owscriptlogger/logs' )}</label>
                    {foreach $logger.actions as $action}
                        <input type="checkbox" class="action_filter" id="action_{$action}" checked="checked" />{$action}
                    {/foreach}
                </fieldset>
            </div>
        </div>
    </div>
    <div class="box-content">
        <div class="context-attributes">
            <div class="block">
                <div class="yui-dt">
	                <table class="log_list">
	                    <thead>
	                        <tr class="yui-dt-first yui-dt-last">
	                            <th class="logger_date"><div class="yui-dt-liner">{'Date'|i18n('owscriptlogger/logs' )}</div></th>
	                            <th class="logger_action"><div class="yui-dt-liner">{'Action'|i18n('owscriptlogger/logs' )}</div></th>
	                            <th class="logger_message"><div class="yui-dt-liner">{'Message'|i18n('owscriptlogger/logs' )}</div></th>
	                        </tr>
	                    </thead>
	                    <tbody class="yui-dt-data">
	                        {foreach $logger.logs as $log sequence array( 'yui-dt-even', 'yui-dt-odd' ) as $style}
	                            <tr class="{if $index|eq(0)}yui-dt-first{/if} {$style} level_{$log.level} action_{$log.action}">
	                                <td class="logger_date"><div class="yui-dt-liner">{$log.date}</div></td>
	                                <td class="logger_action"><div class="yui-dt-liner">{$log.action}</div></td>
	                                <td class="logger_message"><div class="yui-dt-liner">{$log.message}</div></td>
	                            </tr>
	                        {/foreach}
	                    </tbody>
	                </table>
                </div>
            </div>
        </div>
    </div>
</div>