<aside id="menu">
    <div id="navigation">
        <div class="profile-picture">
            <a href="index.html">
                <img src="<?php echo base_url(); ?>assets/images/profile-default.png" class="img-circle m-b" width="100" alt="logo">
            </a>
            <div class="stats-label text-color">
                <span class="font-extra-bold font-uppercase"><?php echo $this->session->userdata("nama_instansi"); ?></span>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <small class="text-muted">Profile <b class="caret"></b></small>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="#">Contacts</a></li>
                        <li><a href="#">Profile</a></li>
                        <li><a href="#">Analytics</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php  echo base_url(); ?>logout">Logout</a></li>
                    </ul>
                </div>
                
            </div>
        </div>
        <ul class="nav" id="side-menu">
        <?php  
            $this->db->select("*")->from("sistem_menu")->where(array("id_submenu"=>0,"stakeholder"=>$this->session->userdata("user_role")))->order_by("urutan","asc");
            $menu=$this->db->get();
            $menu=$menu->result();
            foreach ($menu as $key) {
               if($key->has_sub==0){
               ?>
                <li>
                    <a href="<?php echo base_url(); ?>index.php/<?php echo $key->url; ?>">
                        <i class="<?php echo $key->icon; ?> fa-fw"></i> 
                        <span class="nav-label"></span> <?php echo $key->menu; ?>
                    </a>
                </li>
               <?php }else{
                ?>
                <li>
                    <a href="#">
                    <i class="<?php echo $key->icon; ?> fa-fw"></i>    
                    <span class="nav-label"><?php echo $key->menu; ?></span><span class="fa arrow"></span> </a>
                    <ul class="nav nav-second-level">
                        <?php 
                         $this->db->select("*")->from("sistem_menu")->where(array("id_submenu"=>$key->id_menu,"stakeholder"=>"instansi"))->order_by("urutan","asc");
                         $menu2=$this->db->get();
                         $menu2=$menu2->result();
                         foreach ($menu2 as $key2) {
                             if($key2->has_sub==0){
                               ?>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/<?php echo $key2->url; ?>"> 
                                        <i class="<?php echo $key2->icon; ?> fa-fw"></i> 
                                        <span class="nav-label"></span> <?php echo $key2->menu; ?>
                                    </a>
                                </li>
                               <?php }
                         }
                        ?>
                    </ul>
                </li>
                <?php
               } ?>
               <?php
            }
        ?>
        </ul>
    </div>
</aside>