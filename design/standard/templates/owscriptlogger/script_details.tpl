<div id="log_details">
    <div class="context-block">
        <div class="box-header">
            <div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
                <h1 class="context-title">{'Scripts'|i18n('owscriptlogger/scripts' )}</h1>
                <div class="header-mainline"></div>
            </div></div></div></div></div>
        </div>
        <div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">
            <div class="box-content">
                <div class="context-toolbar"></div>
                <div class="context-attributes">
                    <div class="block">
                    </div>
                </div>
                <div class="context-attributes">
                    <div class="block">
                        <form action={concat('owscriptlogger/scripts/', $script.identifier)|ezurl()} method="POST">
	                        <div class="yui-dt">
	                            <table class="list log_list">
	                                <tbody class="yui-dt-data">
	                                        <tr class="yui-dt-first yui-dt-even">
	                                            <th class="script_identifier"><div class="yui-dt-liner">{'Identifier'|i18n('owscriptlogger/scripts' )}</div></td>
	                                            <td class="script_identifier"><div class="yui-dt-liner">{$script.identifier}</div></td>
	                                        </tr>
	                                </tbody>
	                            </table>
	                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div></div></div></div></div></div>
    </div>
</div>