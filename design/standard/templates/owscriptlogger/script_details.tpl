{ezcss_require( 'owscriptlogger.css' )}
<div id="script_details">
    <div class="context-block">
        <div class="box-header">
            <div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
                <h1 class="context-title">{'Scripts'|i18n('owscriptlogger/scripts' )}</h1>
                <div class="header-mainline"></div>
            </div></div></div></div></div>
        </div>
        <form action={concat('owscriptlogger/scripts/', $script.identifier)|ezurl()} method="POST">
            <div class="box-ml"><div class="box-mr">
                <div class="box-content">
	                <div class="context-toolbar"></div>
	                <div class="context-attributes">
	                    <div class="block">
	                        <div class="yui-dt">
	                            <table class="list log_list">
	                                <tbody class="yui-dt-data">
                                        <tr class="yui-dt-first yui-dt-even">
                                            <td class="script_identifier script_param_title"><div class="yui-dt-liner">{'Identifier'|i18n('owscriptlogger/scripts' )}</div></td>
                                            <td class="script_identifier"><div class="yui-dt-liner">{$script.identifier}</div></td>
                                        </tr>
                                        <tr class="yui-dt-odd">
                                            <td class="script_database_log_level script_param_title"><div class="yui-dt-liner">{'Database log level'|i18n('owscriptlogger/scripts' )}</div></td>
                                            <td class="script_database_log_level"><div class="yui-dt-liner">
                                                <select name="ParametersArray[database_log_level]">
                                                    <option value="notice" {if $script.database_log_level|eq('notice')}selected="selected"{/if}>{'Notice'|i18n('owscriptlogger/all' )}</option>
                                                    <option value="warning" {if $script.database_log_level|eq('warning')}selected="selected"{/if}>{'Warning'|i18n('owscriptlogger/all' )}</option>
                                                    <option value="error" {if $script.database_log_level|eq('error')}selected="selected"{/if}>{'Error'|i18n('owscriptlogger/all' )}</option>
                                                    <option value="disabled" {if $script.database_log_level|eq('disabled')}selected="selected"{/if}>{'Disabled'|i18n('owscriptlogger/all' )}</option>
                                            </div></td>
                                        </tr>
                                        <tr class="yui-dt-even">
                                            <td class="script_fatal_error_recipients script_param_title"><div class="yui-dt-liner">
                                                {'Alert recipients'|i18n('owscriptlogger/scripts' )} 
                                                <p class="help">{'One recipient per line'|i18n('owscriptlogger/scripts' )}</p>
                                            </div></td>
                                            <td class="script_fatal_error_recipients"><div class="yui-dt-liner">
                                                <textarea name="ParametersArray[fatal_error_recipients]">{$script.fatal_error_recipients}</textarea>
                                            </div></td>
                                        </tr>
                                        <tr class="yui-dt-odd">
                                            <td class="script_max_age_error script_param_title"><div class="yui-dt-liner">
                                                {'Error max age'|i18n('owscriptlogger/scripts' )} 
                                                <p class="help">{'In days'|i18n('owscriptlogger/scripts' )}</p>
                                            </div></td>
                                            <td class="script_max_age_error"><div class="yui-dt-liner">
                                                <input type="text" name="ParametersArray[max_age_error]" value="{$script.max_age_error}" />
                                            </div></td>
                                        </tr>
                                        <tr class="yui-dt-even">
                                            <td class="script_max_age_finished script_param_title"><div class="yui-dt-liner">
                                                {'Finished max age'|i18n('owscriptlogger/scripts' )} 
                                                <p class="help">{'In days'|i18n('owscriptlogger/scripts' )}</p>
                                            </div></td>
                                            <td class="script_max_age_finished"><div class="yui-dt-liner">
                                                <input type="text" name="ParametersArray[max_age_finished]" value="{$script.max_age_finished}" />
                                            </div></td>
                                        </tr>
                                        <tr class="yui-dt-odd">
                                            <td class="script_max_age_manually_stoped script_param_title"><div class="yui-dt-liner">
                                                {'Manually stoped max age'|i18n('owscriptlogger/scripts' )} 
                                                <p class="help">{'In days'|i18n('owscriptlogger/scripts' )}</p>
                                            </div></td>
                                            <td class="script_max_age_manually_stoped"><div class="yui-dt-liner">
                                                <input type="text" name="ParametersArray[max_age_manually_stoped]" value="{$script.max_age_manually_stoped}" />
                                            </div></td>
                                        </tr>
                                        <tr class="yui-dt-even">
                                            <td class="script_no_db_log_actions script_param_title"><div class="yui-dt-liner">
                                                {'No database log for actions'|i18n('owscriptlogger/scripts' )} 
                                                <p class="help">{'One action per line'|i18n('owscriptlogger/scripts' )}</p>
                                            </div></td>
                                            <td class="script_no_db_log_actions"><div class="yui-dt-liner">
                                                <textarea name="ParametersArray[no_db_log_actions]">{$script.no_db_log_actions}</textarea>
                                            </div></td>
                                        </tr>
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
                            <input class="defaultbutton" type="submit" name="Configure" value="{'Store'|i18n( 'owscriptlogger/all' )}" />
                        </div>
                    </div>
                </div></div></div></div></div></div>
            </div>
        </div></div>
        </form>
    </div>
</div>