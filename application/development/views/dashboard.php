<?php
/**
 * Dashboard Page
 */
?>
<?php if(isset($this->var['data'])) : ;?>
<pre><?php print_r($this->var['data']);?></pre>
<?php endif; ?>
<!-- Begin Summary Statistics -->
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-light blue-soft" href="javascript:;">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">0</div>
                <div class="desc">New Application</div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-light yellow-crusta" href="javascript:;">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">0</div>
                <div class="desc">New Business</div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-light green-meadow" href="javascript:;">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">0</div>
                <div class="desc">Renewed Business</div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-light red-flamingo" href="javascript:;">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">0</div>
                <div class="desc">Total Registered Business</div>
            </div>
        </a>
    </div>
</div>
<!-- End Summary Statistics -->
<div class="clearfix"></div>
<!-- Begin Graphs -->
<div class="row">
    <div class="col-md-6 col-lg-6">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-share font-red-sunglo hide"></i>
                    <span class="caption-subject font-red-sunglo bold uppercase">Applications</span>
                    <span class="caption-helper">daily stats ...</span>
                </div>
            </div>
<!--            <div class="actions">
                <div class="btn-group">
                    <a class="btn grey-salsa btn-circle btn-sm dropdown-toggle" data-close-others="true" data-hover="dropdown" data-toggle="dropdown" href="javascript:;">
                        Filter Range <span class="fa fa-angle-down"></span>
                    </a>
                    <ul class="drowndown-menu pull-right">
                        <li class="active">
                            <a href="javascript:;"> Jan 2015</a>
                        </li>
                        <li>
                            <a href="javascript:;"> Feb 2015</a>
                        </li>
                        <li>
                            <a href="javascript:;"> Mar 2015</a>
                        </li>
                        <li>
                            <a href="javascript:;"> April 2015</a>
                        </li>
                        <li>
                            <a href="javascript:;"> May 2015</a>
                        </li>
                        <li>
                            <a href="javascript:;"> June 2015</a>
                        </li>
                        <li>
                            <a href="javascript:;"> July 2015</a>
                        </li>
                        <li>
                            <a href="javascript:;"> August 2015</a>
                        </li>
                    </ul>
                </div>
            </div>-->
            <div class="portlet-body">
                
            </div>
        </div>
    </div>
</div>
<!-- End Graphs -->

<!--<div id="site_activities_loading" style="display:none;">
                    <img alt="loading" src="<?php echo ADMIN_THEME;?>img/loading.gif"/>
                </div>
                <div id="site_activities_content" class="display-none" style="display: block;">
                    <div id="site_activities" style="height: 228px; padding: 0px; position: relative;">
                        <canvas class="flot-base" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 448px; height: 228px;" width="448" height="228"></canvas>
                        <div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);">
                            <div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;">
                                <div style="position: absolute; max-width: 44px; top: 209px; font: small-caps 400 10px/18px 'Open Sans',sans-serif; color: rgb(111, 123, 138); left: 21px; text-align: center;">DEC</div>
                                <div style="position: absolute; max-width: 44px; top: 209px; font: small-caps 400 10px/18px 'Open Sans',sans-serif; color: rgb(111, 123, 138); left: 67px; text-align: center;">JAN</div>
                                <div style="position: absolute; max-width: 44px; top: 209px; font: small-caps 400 10px/18px 'Open Sans',sans-serif; color: rgb(111, 123, 138); left: 112px; text-align: center;">FEB</div>
                                <div style="position: absolute; max-width: 44px; top: 209px; font: small-caps 400 10px/18px 'Open Sans',sans-serif; color: rgb(111, 123, 138); left: 155px; text-align: center;">MAR</div>
                                <div style="position: absolute; max-width: 44px; top: 209px; font: small-caps 400 10px/18px 'Open Sans',sans-serif; color: rgb(111, 123, 138); left: 202px; text-align: center;">APR</div>
                                <div style="position: absolute; max-width: 44px; top: 209px; font: small-caps 400 10px/18px 'Open Sans',sans-serif; color: rgb(111, 123, 138); left: 246px; text-align: center;">MAY</div>
                                <div style="position: absolute; max-width: 44px; top: 209px; font: small-caps 400 10px/18px 'Open Sans',sans-serif; color: rgb(111, 123, 138); left: 292px; text-align: center;">JUN</div>
                                <div style="position: absolute; max-width: 44px; top: 209px; font: small-caps 400 10px/18px 'Open Sans',sans-serif; color: rgb(111, 123, 138); left: 339px; text-align: center;">JUL</div>
                                <div style="position: absolute; max-width: 44px; top: 209px; font: small-caps 400 10px/18px 'Open Sans',sans-serif; color: rgb(111, 123, 138); left: 382px; text-align: center;">AUG</div>
                                <div style="position: absolute; max-width: 44px; top: 209px; font: small-caps 400 10px/18px 'Open Sans',sans-serif; color: rgb(111, 123, 138); left: 429px; text-align: center;">SEP</div>
                            </div>
                            <div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;">
                                <div style="position: absolute; top: 197px; font: small-caps 400 10px/14px 'Open Sans',sans-serif; color: rgb(111, 123, 138); left: 19px; text-align: right;">0</div>
                                <div style="position: absolute; top: 149px; font: small-caps 400 10px/14px 'Open Sans',sans-serif; color: rgb(111, 123, 138); left: 7px; text-align: right;">500</div>
                                <div style="position: absolute; top: 100px; font: small-caps 400 10px/14px 'Open Sans',sans-serif; color: rgb(111, 123, 138); left: 1px; text-align: right;">1000</div>
                                <div style="position: absolute; top: 52px; font: small-caps 400 10px/14px 'Open Sans',sans-serif; color: rgb(111, 123, 138); left: 1px; text-align: right;">1500</div>
                                <div style="position: absolute; top: 3px; font: small-caps 400 10px/14px 'Open Sans',sans-serif; color: rgb(111, 123, 138); left: 1px; text-align: right;">2000</div>
                            </div>
                            <canvas class="flot-overlay" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 448px; height: 228px;" width="448" height="228"></canvas>
                        </div>
                    </div>
                </div>-->
