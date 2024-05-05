<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-jet-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                @if (auth()->user()->hasPermissionTo('accueil viewer'))
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-jet-nav-link href="{{ route('dashboard') }}" class="text-dark" :active="request()->routeIs('dashboard')">
                            {{ __('Accueil') }}
                        </x-jet-nav-link>
                    </div>
                @endif

                @if (auth()->user()->hasPermissionTo('administration viewer'))
                    <x-nav-dropdown title="Administration" align="right" width="48">
                        @can('view-any', App\Models\Commune::class)
                            <x-dropdown-link href="{{ route('communes.index') }}">
                                Regions
                            </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Section::class)
                            <x-dropdown-link href="{{ route('sections.index') }}">
                                Departements
                            </x-dropdown-link>
                        @endcan
                        <!-- @can('view-any', App\Models\SousSection::class)
                            <x-dropdown-link href="{{ route('sous-sections.index') }}">
                                Sous Sections
                            </x-dropdown-link>
                        @endcan -->
                        <!-- @can('view-any', App\Models\Departement::class)
    <x-dropdown-link href="{{ route('departements.index') }}">
                            Departements
                            </x-dropdown-link>
@endcan -->
                        @can('view-any', App\Models\Departement::class)
                            <x-dropdown-link href="{{ route('rcommunes.index') }}">
                                Communes
                            </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Quartier::class)
                            <x-dropdown-link href="{{ route('quartiers.index') }}">
                                Sections
                            </x-dropdown-link>
                        @endcan
                        <hr class="w-full bg-gray-300 h-1/2" />
                        @can('view-any', App\Models\LieuVote::class)
                            <x-dropdown-link href="{{ route('lieu-votes.index') }}">
                                Lieu de votes
                            </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\BureauVote::class)
                            <x-dropdown-link href="{{ route('bureau-votes.index') }}">
                                Bureau Votes
                            </x-dropdown-link>
                        @endcan
                        <hr class="w-full bg-gray-300 h-1/2" />
                        @can('view-any', App\Models\User::class)
                            <x-dropdown-link href="{{ route('users.index') }}">
                                Utilisateurs
                            </x-dropdown-link>
                        @endcan
                        @can('operateurs-view', App\Models\User::class)
                            <x-dropdown-link href="{{ route('operateurs.index') }}">
                                Opérateurs
                            </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\OperateurSuivi::class)
                            <x-dropdown-link href="{{ route('operateur-suivis.index') }}">
                                Opérateurs du Suivi
                            </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Candidat::class)
                            <x-dropdown-link href="{{ route('candidats.index') }}">
                                Candidats
                            </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Parrain::class)
                            <x-dropdown-link href="{{ route('parrains.index') }}">
                                Parrains
                            </x-dropdown-link>
                        @endcan
                        <hr class="w-full bg-gray-300 h-1/2" />
                        @can('view-any', App\Models\AgentDeSection::class)
                            <x-dropdown-link href="{{ route('agent-de-sections.index') }}">
                                Responsable De Sections
                            </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\SupLieuDeVote::class)
                            <x-dropdown-link href="{{ route('sup-lieu-de-votes.index') }}">
                                Sup Lieu De Votes
                            </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\AgentDuBureauVote::class)
                            <x-dropdown-link href="{{ route('agent-du-bureau-votes.index') }}">
                                Agent Du Bureau Votes
                            </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Rabatteur::class)
                            <x-dropdown-link href="{{ route('rabatteurs.index') }}">
                                Rabatteurs
                            </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\AgentTerrain::class)
                            <x-dropdown-link href="{{ route('agent-terrains.index') }}">
                                Les Parrains
                            </x-dropdown-link>
                        @endcan
                        <hr class="w-full bg-gray-300 h-1/2" />
                        @can('view-any', App\Models\ProcesVerbal::class)
                            <x-dropdown-link href="{{ route('proces-verbals.index') }}">
                                Procès Verbals
                            </x-dropdown-link>
                        @endcan
                    </x-nav-dropdown>
                @endif

                @if (auth()->user()->hasPermissionTo('recensement viewer'))
                    <x-nav-dropdown title="Recensement" align="right" width="48">
                        @can('recens-commune', App\Models\Commune::class)
                            <x-dropdown-link href="{{ route('recens.communes.index') }}">
                                Regions
                            </x-dropdown-link>
                        @endcan
                        @can('recens-section', App\Models\Section::class)
                            <x-dropdown-link href="{{ route('recens.sections.index') }}">
                                Departements
                            </x-dropdown-link>
                        @endcan
                        <!-- @can('recens-sous-section', App\Models\SousSection::class)
                            <x-dropdown-link href="{{ route('recens.soussections.index') }}">
                                Sous Sections
                            </x-dropdown-link>
                        @endcan -->
                        @can('recens-quartier', App\Models\Quartier::class)
                            <x-dropdown-link href="{{ route('recens.rcommunes.index') }}">
                                Communes
                            </x-dropdown-link>
                        @endcan
                        @can('recens-quartier', App\Models\Quartier::class)
                            <x-dropdown-link href="{{ route('recens.quartiers.index') }}">
                                Sections
                            </x-dropdown-link>
                        @endcan
                        @can('recens-lieuvote', App\Models\LieuVote::class)
                            <x-dropdown-link href="{{ route('recens.lieuvotes.index') }}">
                                Lieu de votes
                            </x-dropdown-link>
                        @endcan
                        @can('recens-parrain', App\Models\Parrain::class)
                            <x-dropdown-link href="{{ route('recens.parrains.index') }}">
                                Parrains
                            </x-dropdown-link>
                        @endcan
                    </x-nav-dropdown>
                @endif

                @if (auth()->user()->hasPermissionTo('suivis viewer'))
                    <x-nav-dropdown title="Suivi" align="right" width="48">
                        @can('suivi-commune', App\Models\Commune::class)
                            <x-dropdown-link href="{{ route('suivi.communes.index') }}">
                                Regions
                            </x-dropdown-link>
                        @endcan
                        @can('suivi-lieuvote', App\Models\LieuVote::class)
                            <x-dropdown-link href="{{ route('suivi.lieuvotes.index') }}">
                                Lieu de votes
                            </x-dropdown-link>
                        @endcan
                        @can('suivi-bureauvote', App\Models\BureauVote::class)
                            <x-dropdown-link href="{{ route('suivi.bureauvotes.index') }}">
                                Bureau de votes
                            </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\CorParrain::class)
                            <x-dropdown-link href="{{ route('cor-parrains.index') }}">
                                Electorat
                            </x-dropdown-link>
                        @endcan
                        @can('suivi-agentterrain', App\Models\AgentTerrain::class)
                            <x-dropdown-link href="{{ route('agentmessages.index') }}">
                                Message aux Agents
                            </x-dropdown-link>
                        @endcan
                    </x-nav-dropdown>
                @endif

                @if (auth()->user()->hasPermissionTo('resultats viewer'))
                    <x-nav-dropdown title="Résultats" align="right" width="48">
                        @can('resultat-commune', App\Models\Commune::class)
                            <x-dropdown-link href="{{ route('resultats.communes.index') }}">
                                Regions
                            </x-dropdown-link>
                        @endcan
                        @can('resultat-lieuvote', App\Models\LieuVote::class)
                            <x-dropdown-link href="{{ route('resultats.lieuvotes.index') }}">
                                Lieu de votes
                            </x-dropdown-link>
                        @endcan
                        @can('resultat-bureauvote', App\Models\BureauVote::class)
                            <x-dropdown-link href="{{ route('resultats.bureauvotes.index') }}">
                                Bureau de votes
                            </x-dropdown-link>
                        @endcan
                    </x-nav-dropdown>
                @endif

                @if (auth()->user()->hasPermissionTo('alertor viewer'))
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <div class="relative">
                        <div>
                            @php
                                $counter = App\Models\Alerte::where("viewers", null)->count();
                            @endphp
                            <button
                                class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <a href="{{route('alerte.agentlist.index')}}"><div style="color: black">{{ $counter }} Alertes <i class="ion ion-md-alarm" style="color:red"></i></div></a>
                            </button>
                        </div>
                    </div>
                </div>
                @endif

                @if (Auth::user()->hasPermissionTo('view roles') || Auth::user()->hasPermissionTo('view permissions'))
                    <x-nav-dropdown title="Les Accès" align="right" width="48">

                        @can('view roles', App\Models\User::class)
                            <x-dropdown-link href="{{ route('roles.index') }}">Roles</x-dropdown-link>
                        @endcan

                        @can('view permissions', App\Models\User::class)
                            <x-dropdown-link href="{{ route('permissions.index') }}">Permissions</x-dropdown-link>
                        @endcan

                    </x-nav-dropdown>
                @endif
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ml-3 relative">
                        <x-jet-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-jet-dropdown-link
                                        href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-jet-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-jet-dropdown-link>
                                    @endcan

                                    <div class="border-t border-gray-100"></div>

                                    <!-- Team Switcher -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Switch Teams') }}
                                    </div>

                                    @foreach (Auth::user()->allTeams() as $team)
                                        <x-jet-switchable-team :team="$team" />
                                    @endforeach
                                </div>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        src="{{ Auth::user()->profile_photo_url }}"
                                        alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ 'Panel du compte' }}
                                <!-- <br>
                                <span style="font-size:10px;">(TKFAART:tchimoukfa71@gmail.com)</span> -->
                            </div>

                            @can('super-admin', App\Models\User::class)
                                <!-- <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                    {{ __('Profile') }}
                                </x-jet-dropdown-link> -->

                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                        {{ __('API Tokens') }}
                                    </x-jet-dropdown-link>
                                @endif
                            @endcan

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Déconnecter') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-jet-responsive-nav-link>

            @can('view-any', App\Models\AgentDeSection::class)
                <x-jet-responsive-nav-link href="{{ route('agent-de-sections.index') }}">
                    Responsable De Sections
                </x-jet-responsive-nav-link>
            @endcan
            @can('view-any', App\Models\AgentDuBureauVote::class)
                <x-jet-responsive-nav-link href="{{ route('agent-du-bureau-votes.index') }}">
                    Agent Du Bureau Votes
                </x-jet-responsive-nav-link>
            @endcan
            @can('view-any', App\Models\AgentTerrain::class)
                <x-jet-responsive-nav-link href="{{ route('agent-terrains.index') }}">
                    Les Parrains
                </x-jet-responsive-nav-link>
            @endcan
            @can('view-any', App\Models\BureauVote::class)
                <x-jet-responsive-nav-link href="{{ route('bureau-votes.index') }}">
                    Bureau Votes
                </x-jet-responsive-nav-link>
            @endcan
            @can('view-any', App\Models\Candidat::class)
                <x-jet-responsive-nav-link href="{{ route('candidats.index') }}">
                    Candidats
                </x-jet-responsive-nav-link>
            @endcan
            @can('view-any', App\Models\Commune::class)
                <x-jet-responsive-nav-link href="{{ route('communes.index') }}">
                    Regions
                </x-jet-responsive-nav-link>
            @endcan
            @can('view-any', App\Models\LieuVote::class)
                <x-jet-responsive-nav-link href="{{ route('lieu-votes.index') }}">
                    Lieu Votes
                </x-jet-responsive-nav-link>
            @endcan
            @can('view-any', App\Models\Parrain::class)
                <x-jet-responsive-nav-link href="{{ route('parrains.index') }}">
                    Parrains
                </x-jet-responsive-nav-link>
            @endcan
            @can('view-any', App\Models\CorParrain::class)
                <x-jet-responsive-nav-link href="{{ route('cor-parrains.index') }}">
                    Electorat
                </x-jet-responsive-nav-link>
            @endcan
            @can('view-any', App\Models\ProcesVerbal::class)
                <x-jet-responsive-nav-link href="{{ route('proces-verbals.index') }}">
                    Proces Verbals
                </x-jet-responsive-nav-link>
            @endcan
            @can('view-any', App\Models\Quartier::class)
                <x-jet-responsive-nav-link href="{{ route('quartiers.index') }}">
                    Quartiers
                </x-jet-responsive-nav-link>
            @endcan
            @can('view-any', App\Models\Section::class)
                <x-jet-responsive-nav-link href="{{ route('sections.index') }}">
Departements
                </x-jet-responsive-nav-link>
            @endcan
            @can('view-any', App\Models\SousSection::class)
                <x-jet-responsive-nav-link href="{{ route('sous-sections.index') }}">
                    Sous Sections
                </x-jet-responsive-nav-link>
            @endcan
            @can('view-any', App\Models\SupLieuDeVote::class)
                <x-jet-responsive-nav-link href="{{ route('sup-lieu-de-votes.index') }}">
                    Sup Lieu De Votes
                </x-jet-responsive-nav-link>
            @endcan
            @can('view-any', App\Models\OperateurSuivi::class)
                <x-jet-responsive-nav-link href="{{ route('operateur-suivis.index') }}">
                    Operateur Suivis
                </x-jet-responsive-nav-link>
            @endcan
            @can('view-any', App\Models\Rabatteur::class)
                <x-jet-responsive-nav-link href="{{ route('rabatteurs.index') }}">
                    Rabatteurs
                </x-jet-responsive-nav-link>
            @endcan
            @can('view-any', App\Models\User::class)
                <x-jet-responsive-nav-link href="{{ route('users.index') }}">
                    Users
                </x-jet-responsive-nav-link>
            @endcan
            <!-- @can('view-any', App\Models\Departement::class)
    <x-jet-responsive-nav-link href="{{ route('departements.index') }}">
                    Departements
                    </x-jet-responsive-nav-link>
@endcan -->

            @if (Auth::user()->can('view-any', Spatie\Permission\Models\Role::class) ||
                    Auth::user()->can('view-any', Spatie\Permission\Models\Permission::class))
                @can('view-any', Spatie\Permission\Models\Role::class)
                    <x-jet-responsive-nav-link href="{{ route('roles.index') }}">Roles</x-jet-responsive-nav-link>
                @endcan

                @can('view-any', Spatie\Permission\Models\Permission::class)
                    <x-jet-responsive-nav-link href="{{ route('permissions.index') }}">Permissions
                    </x-jet-responsive-nav-link>
                @endcan
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                            alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <!-- <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-jet-responsive-nav-link> -->

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('Déconnecter') }}
                    </x-jet-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                        :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-jet-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-jet-responsive-nav-link>
                    @endcan

                    <div class="border-t border-gray-200"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</nav>
