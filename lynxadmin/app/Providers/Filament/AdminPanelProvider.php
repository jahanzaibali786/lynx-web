<?php

namespace App\Providers\Filament;

use App\Models\PricingFeaturePlan;
use App\Models\PricingPlan;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Assets\Font;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Resources\AddOnCategories\AddOnCategoriesResource;
use App\Filament\Resources\Addons\AddonResource;
use App\Filament\Resources\Products\ProductResource;
use App\Filament\Resources\ProductCards\ProductCardResource;
use App\Filament\Resources\Features\FeatureResource;
use App\Filament\Resources\PricingFeatures\PricingFeatureResource;
use App\Filament\Resources\PricingPlans\PricingPlanResource;
use App\Filament\Resources\Blogs\BlogResource;
use App\Filament\Resources\AdmissionApplications\AdmissionApplicationResource;
use App\Filament\Resources\CareerApplications\CareerApplicationResource;
use App\Filament\Resources\CareerOpportunities\CareerOpportunityResource;
use App\Filament\Resources\Galleries\GalleryResource;
use App\Filament\Resources\GalleryImages\GalleryImageResource;
use App\Filament\Resources\News\NewsResource;
use App\Filament\Resources\UpcomingEvents\UpcomingEventResource;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('/')
            ->login()
            // ->domain(env('APP_URL', 'localhost'))
            ->colors([
                'primary' => Color::Red,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->brandName("Lynx Admin")
            ->favicon(asset("images/lynx-logo-small.png"))
            ->sidebarCollapsibleOnDesktop()
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->plugins([
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            // ->navigationGroups([
            //     NavigationGroup::make()
            //         ->label("Addon Setup")
            //         ->icon('heroicon-o-home'),
            // ])
            ->navigation(function (NavigationBuilder $builder) {
                return $builder->groups([
                    NavigationGroup::make()
                        ->items([
                            \Filament\Navigation\NavigationItem::make('Dashboard')
                                ->icon('heroicon-o-home')
                                ->url(route('filament.admin.pages.dashboard')),
                        ]),

                    // NavigationGroup::make()
                    //     ->items([
                    //         ...BlogResource::getNavigationItems(),
                    //     ]),
                    NavigationGroup::make()
                        ->items([
                            ...AdmissionApplicationResource::getNavigationItems(),
                        ]),
                    NavigationGroup::make()
                        ->items([
                            ...CareerApplicationResource::getNavigationItems()
                        ]),
                    NavigationGroup::make()
                        ->items([
                            ...CareerOpportunityResource::getNavigationItems()
                        ]),
                    NavigationGroup::make()
                        ->items([
                            ...UpcomingEventResource::getNavigationItems()
                        ]),
                    NavigationGroup::make()
                        ->items([
                            ...NewsResource::getNavigationItems()
                        ]),
                    NavigationGroup::make()
                        ->label('Galleries')
                        ->icon('heroicon-o-photo')
                        ->items([
                            ...GalleryResource::getNavigationItems(),
                            ...GalleryImageResource::getNavigationItems(),
                        ])
                        ->collapsed(),

                ]);
            });

    }
}
