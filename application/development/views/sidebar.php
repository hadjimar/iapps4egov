    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <div class="page-sidebar navbar-collapse collapse">
            
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu page-sidebar-menu-hover-submenu" data-slide-speed="200" data-auto-scroll="true" data-keep-expanded="false">
        <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <li class="sidebar-toggler-wrapper">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler">
                </div>
                <!-- END SIDEBAR TOGGLER BUTTON -->
            </li>
            
            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
<!--            <li class="sidebar-search-wrapper hidden-xs">
             BEGIN RESPONSIVE QUICK SEARCH FORM 
             DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box 
             DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box 
                <form class="sidebar-search" action="extra_search.html" method="POST">
                    <a href="javascript:;" class="remove">
                    <i class="icon-close"></i>
                    </a>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
                        </span>
                    </div>
                </form>
             END RESPONSIVE QUICK SEARCH FORM 
            </li>-->
<!--            <li class="start active ">
                <a href="<?php echo BASE_URL;?>">
                <i class="icon-home"></i>
                <span class="title">Dashboard</span>
                <span class="selected"></span>
                </a>
            </li>-->

        <?php if(count($this->var['sidebar_menu_list'])>0):?>
            <?php foreach($this->var['sidebar_menu_list'] as $main_menu):?>
            <li>
                <a href="<?php echo $main_menu['Permalink']; ?>">
                    <i class="<?php echo $main_menu['MenuIcon'];?>"></i>
                    <span class="title"><?php echo $main_menu['MenuName'];?></span>
                    <?php if(array_key_exists('SubMenu', $main_menu)): ?><span class="arrow "></span> <?php endif; ?>
                </a>
                <!-- Begin Sub Menu -->
                <?php if(array_key_exists('SubMenu', $main_menu)) :?>
                <ul class="sub-menu">
                    <?php foreach($main_menu['SubMenu'] as $sub_menu):?>
                    <li>
                        <a href="<?php echo $sub_menu['Permalink'];?>">
                            <i class="<?php echo $sub_menu['MenuIcon'];?>"></i>
                            <span><?php echo $sub_menu['MenuName'];?></span>
                        </a>
                        <!-- Begin Grandchild Menu -->
                        <?php if(array_key_exists('GrandchildMenu', $sub_menu)) :?>
                        <ul class="sub-menu">
                            <?php foreach($sub_menu['GrandchildMenu'] as $grandchild_menu):?>
                            <li>
                                <a href="<?php echo $grandchild_menu['Permalink'];?>">
                                    <i class="<?php echo $grandchild_menu['MenuIcon'];?>"></i>
                                    <span><?php echo $grandchild_menu['MenuName'];?></span>
                                </a>
                            </li>
                            <?php endforeach; /*($main_menu['SubMenu'] as $sub_menu)*/ ?>
                        </ul>
                        <?php endif; /*(array_key_exists('SubMenu', $main_menu))*/?>
                        <!-- End Sub Menu -->
                    </li>
                    <?php endforeach; /*($main_menu['SubMenu'] as $sub_menu)*/ ?>
                </ul>
                <?php endif; /*(array_key_exists('SubMenu', $main_menu))*/?>
                <!-- End Sub Menu -->
            </li>
            <?php endforeach; /*($this->var['sidebar_menu_list'] as $main_menu)*/?>
        <?php endif; /*(count($this->var['sidebar_menu_list'])>0)*/?>
            
        </ul>
        <!-- END SIDEBAR MENU -->
        </div>
    </div>
    <!-- END SIDEBAR -->