<template>
    <div>
            <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
                    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Company name</a>
                    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
                    <ul class="navbar-nav px-3">
                      <li class="nav-item text-nowrap">
                        <a class="nav-link" href="#">Sign out</a>
                      </li>
                    </ul>
                  </nav>
        <div class="container-fluid">

        
        <div class="row">
            <div class="col-sm-3 col-md-2">
                <div class="col-md-2 bg-light sidebar">
                <div class="sidebar-sticky">
                <ul class="nav flex-column" id="adminMenu">
                    <li class="nav-item">
                    <b-link to="/admin" class="nav-link border-bottom" active-class="navactive">DashBoard</b-link>                    
                    </li>
                    <li class="nav-item">
                    <b-link to="/admin/subject" class="nav-link  border-bottom" active-class="navactive">ข้อมูลวิชา</b-link>                                       
                    </li>
                    <li class="nav-item">
                    <b-link to="/admin/article" class="nav-link  border-bottom" active-class="navactive">ข้อมูลหัวข้อวิชา</b-link>                                        
                    </li>
                    <li class="nav-item">
                    <b-link to="/admin/webboard" class="nav-link  border-bottom" active-class="navactive">กระดานข่าว</b-link>                                        
                    </li>
                    <li class="nav-item">
                    <b-link to="/admin/flashnew" class="nav-link border-bottom" active-class="navactive">ข่าวสารน่ารู้</b-link>                                        
                    </li>
                </ul> 
                </div>
                </div>
            </div>
            <div class="col-sm-9 col-md-10">             
                
                <router-view></router-view>
                
            </div>
        </div>
    </div>
    </div>
</template>
<script>
export default {
    data(){
        return{

        }
    }
}
</script>