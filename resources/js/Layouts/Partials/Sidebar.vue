<template>
    <div class="sidebar">
        <nav class="mt-2">
            <ul
                class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false"
            >
                <li class="nav-item">
                    <Link
                        :href="route('situation.index')"
                        class="nav-link"
                        :class="{
                            active: $page.component.startsWith('Situation/'),
                        }"
                    >
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>
                            Situation
                            <span class="badge badge-info right">2</span>
                        </p>
                    </Link>
                </li>
                <li
                    class="nav-item"
                    :class="{
                        'menu-open': $page.component.startsWith('Boulanger/'),
                    }"
                >
                    <a
                        href="#"
                        class="nav-link"
                        :class="{
                            active: $page.component.startsWith('Boulanger/'),
                        }"
                    >
                        <i class="nav-icon fa fa-bold"></i>
                        <p class="bold">
                            Boulangeries
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <Link
                                :href="route('boulanger.index')"
                                class="nav-link"
                                :class="{
                                    active:
                                        $page.component == 'Boulanger/Index',
                                }"
                            >
                                <i class="far fa-circle nav-icon"></i>
                                <p>Liste</p>
                            </Link>
                        </li>
                    </ul>
                </li>

                <li
                    class="nav-item"
                    :class="{
                        'menu-open': $page.component.startsWith('Employeur/'),
                    }"
                >
                    <a
                        href="#"
                        class="nav-link"
                        :class="{
                            active: $page.component.startsWith('Employeur/'),
                        }"
                    >
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Employeurs
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <Link
                                :href="route('employeur.index')"
                                class="nav-link"
                                :class="{
                                    active:
                                        $page.component == 'Employeur/Index',
                                }"
                            >
                                <i class="far fa-circle nav-icon"></i>
                                <p>Liste</p>
                            </Link>
                        </li>
                    </ul>
                </li>

                <li
                    class="nav-item"
                    :class="{
                        'menu-open': $page.component.includes('Recette/'),
                    }"
                >
                    <a
                        href="#"
                        class="nav-link"
                        :class="{
                            active: $page.component.includes('Recette/'),
                        }"
                    >
                        <i class="nav-icon fa fa-plus-circle"></i>
                        <p>
                            Recettes
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <Link
                                :href="route('recette.index')"
                                class="nav-link"
                                :class="{
                                    active: $page.component == 'Recette/Index',
                                }"
                            >
                                <i class="far fa-circle nav-icon"></i>
                                <p>Recettes quotidienne</p>
                            </Link>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <Link
                                :href="route('autrerecette.index')"
                                class="nav-link"
                                :class="{
                                    active:
                                        $page.component ==
                                        'Recette/AutreRecette/Index',
                                }"
                            >
                                <i class="far fa-circle nav-icon"></i>
                                <p>Aute recettes</p>
                            </Link>
                        </li>
                    </ul>
                </li>
                <li
                    class="nav-item"
                    :class="{
                        'menu-open': $page.component.includes('Depence/'),
                    }"
                >
                    <a
                        href="#"
                        class="nav-link"
                        :class="{
                            active: $page.component.includes('Depence/'),
                        }"
                    >
                        <i class="nav-icon fas fa-minus-circle"></i>
                        <p>
                            Depences
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <Link
                                :href="route('depence.index')"
                                class="nav-link"
                                :class="{
                                    active: $page.component == 'Depence/Index',
                                }"
                            >
                                <i class="far fa-circle nav-icon"></i>
                                <p>Depences quotidienne</p>
                            </Link>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <Link
                                :href="route('avancesalaire.index')"
                                class="nav-link"
                                :class="{
                                    active:
                                        $page.component ==
                                        'Depence/AvanceSalaire/Index',
                                }"
                            >
                                <i class="far fa-circle nav-icon"></i>
                                <p>Avance salaire</p>
                            </Link>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <Link
                                :href="route('salaire.index')"
                                class="nav-link"
                                :class="{
                                    active:
                                        $page.component ==
                                        'Depence/Salaire/Index',
                                }"
                            >
                                <i class="far fa-circle nav-icon"></i>
                                <p>Salaire</p>
                            </Link>
                        </li>
                    </ul>
                </li>

                <li
                    class="nav-item"
                    :class="{
                        'menu-open': $page.component.startsWith('Operation/'),
                    }"
                >
                    <a
                        href="#"
                        class="nav-link"
                        :class="{
                            active: $page.component.startsWith('Operation/'),
                        }"
                    >
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Operations
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <Link
                                :href="route('operationgrade.index')"
                                class="nav-link"
                                :class="{
                                    active:
                                        $page.component ==
                                        'Operation/Grade/Index',
                                }"
                            >
                                <i class="far fa-circle nav-icon"></i>
                                <p>Grades</p>
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link
                                :href="route('operationproprietaire.index')"
                                class="nav-link"
                                :class="{
                                    active:
                                        $page.component ==
                                        'Operation/Proprietaire/Index',
                                }"
                            >
                                <i class="far fa-circle nav-icon"></i>
                                <p>Proprietaires</p>
                            </Link>
                        </li>

                        <li class="nav-item">
                            <Link
                                :href="route('operationtypedepence.index')"
                                class="nav-link"
                                :class="{
                                    active:
                                        $page.component ==
                                        'Operation/TypeDepence/Index',
                                }"
                            >
                                <i class="far fa-circle nav-icon"></i>
                                <p>Type de depences</p>
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link
                                :href="route('operationtyperecette.index')"
                                class="nav-link"
                                :class="{
                                    active:
                                        $page.component ==
                                        'Operation/TypeRecette/Index',
                                }"
                            >
                                <i class="far fa-circle nav-icon"></i>
                                <p>Type de recettes</p>
                            </Link>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
</script>
