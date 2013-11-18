<div id="log_details">
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
	                    </div>
	                </div>
	                <div class="context-attributes">
	                    <div class="block">
	                        <div class="yui-dt">
	                            <table class="list log_list">
	                                <tbody class="yui-dt-data">
                                        <tr class="yui-dt-first yui-dt-even">
                                            <th class="script_identifier"><div class="yui-dt-liner">{'Identifier'|i18n('owscriptlogger/scripts' )}</div></td>
                                            <td class="script_identifier"><div class="yui-dt-liner">{$script.identifier}</div></td>
                                        </tr>
                                        <tr class="yui-dt-first yui-dt-odd">
                                            <th class="script_identifier"><div class="yui-dt-liner">{'Database log level'|i18n('owscriptlogger/scripts' )}</div></td>
                                            <td class="script_identifier"><div class="yui-dt-liner">
                                                <select name="ParametersArray[database_log_level]">
                                                    <option value="notice" {if $script.database_log_level|eq('notice')}selected="selected"{/if}>{'Notice'|i18n('owscriptlogger/scripts' )}</option>
                                                    <option value="warning" {if $script.database_log_level|eq('warning')}selected="selected"{/if}>{'Warning'|i18n('owscriptlogger/scripts' )}</option>
                                                    <option value="error" {if $script.database_log_level|eq('error')}selected="selected"{/if}>{'Error'|i18n('owscriptlogger/scripts' )}</option>
                                                    <option value="disabled" {if $script.database_log_level|eq('disabled')}selected="selected"{/if}>{'Disabled'|i18n('owscriptlogger/scripts' )}</option>
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