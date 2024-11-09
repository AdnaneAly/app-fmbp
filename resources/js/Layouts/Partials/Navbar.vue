<template>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a
                    class="nav-link"
                    data-widget="pushmenu"
                    href="#"
                    role="button"
                    ><i class="fas fa-bars"></i
                ></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <Link :href="route('home')" class="nav-link">Home</Link>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <Link :href="route('contact')" class="nav-link">Contact</Link>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a
                    class="nav-link"
                    data-widget="navbar-search"
                    href="#"
                    role="button"
                >
                    <i class="fas fa-search"></i>
                </a>
                <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input
                                class="form-control form-control-navbar"
                                type="search"
                                placeholder="Search"
                                aria-label="Search"
                            />
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button
                                    class="btn btn-navbar"
                                    type="button"
                                    data-widget="navbar-search"
                                >
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>
            <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
              <img src="~admin-lte/dist/img/avatar5.png" class="user-image img-circle elevation-2" alt="User Image">
              <span class="d-none d-md-inline">{{ user.name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <!-- User image -->
              <li class="user-header bg-gradient-cyan">
                <img src="~admin-lte/dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">

                <p>
                    {{ user.name }}
                  <small>Member since {{ user.created_at }}</small>
                </p>
              </li>
              <!-- Menu Body -->

              <!-- Menu Footer-->
              <li class="user-footer">
                <button @click="logout" type="button" class="btn btn-default btn-flat ">Se déconnecter</button>
              </li>
            </ul>
          </li>
        </ul>
    </nav>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    import { usePage, router } from '@inertiajs/vue3';
    import { computed } from 'vue';


    const user = computed(() => {
        return usePage().props.auth.user
    });

    const url = route("logout");
    const logout = () => {
        router.delete(
        url,
        { },
    );
    }
</script>
