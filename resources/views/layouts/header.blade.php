<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('dashboard') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        @php
            $words = explode(' ', $settings->nama_perusahaan);
            $word  = '';
            foreach ($words as $w) {
                $word .= $w[0];
            }
        @endphp
        <span class="logo-mini">{{ $word }}</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>{{ $settings->nama_perusahaan }}</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ url(auth()->user()->foto ?? '') }}" class="user-image img-profil"
                            alt="User Image">
                        <span class="hidden-xs">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ url(auth()->user()->foto ?? '') }}" class="img-circle img-profil"
                                alt="User Image">

                            <p>
                                {{ auth()->user()->name }} - {{ auth()->user()->email }}
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ route('user.profil') }}" class="btn btn-default btn-flat">Profil</a>
                            </div>
                            <div class="pull-right">
                                 {{-- <a href="{{ route('logout') }}" class="dropdown-item" onclick="logout()">
                                    <i class="fas fa-sign-out-alt mr-2"></i> 
                                    <span class="float-right text-muted text-sm">Keluar</span>
                                  </a> --}}
                                <a href="#" class="btn btn-default btn-flat" onclick="logout()" method="post">Keluar</a>
                                {{-- <a href="#" class="dropdown-item" onclick="logout()">
                                    <i class="fas fa-sign-out-alt mr-2"></i> 
                                    <span class="float-right text-muted text-sm">Logout</span>
                                </a> --}}
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                              </form>

                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<script type="text/javascript">
        const logout = ()=>{
        swal({
            type:"info",
            title: "Apakah anda yakin akan keluar?",
            confirmButtonText: "<i class='fa fa-thumbs-up'></i> Ya",
            showCancelButton:true,
            cancelButtonColor: '#d33',
            cancelButtonText: "<i class='fa fa-window-close'></i> Tidak"
        }).then(res=>{
          if(res.value){
              $("#logout-form").submit();
          }
        });
      }
</script>

{{-- <form action="{{ route('logout') }}" method="post" id="logout-form" style="display: none;">
    @csrf
</form> --}}