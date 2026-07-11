<x-filament-widgets::widget>
    <x-filament::section
        style="background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%); border: none; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); border-radius: 0.75rem; padding: 0;"
    >
        <style>
            .welcome-container {
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                padding: 1.5rem;
                gap: 1rem;
            }
            .welcome-text-group {
                display: flex;
                align-items: center;
                gap: 1rem;
            }
            .welcome-buttons {
                display: flex;
                gap: 0.5rem;
                flex-wrap: wrap;
            }
            @media (max-width: 768px) {
                .welcome-container {
                    flex-direction: column;
                    align-items: flex-start;
                }
                .welcome-buttons {
                    width: 100%;
                    justify-content: flex-start;
                    margin-top: 0.5rem;
                }
            }
        </style>
        
        <div class="welcome-container">
            <div class="welcome-text-group">
                <div style="display: flex; height: 3rem; width: 3rem; flex-shrink: 0; align-items: center; justify-content: center; border-radius: 9999px; background-color: rgba(255, 255, 255, 0.2);">
                    <x-filament::icon icon="heroicon-o-sparkles" style="height: 1.5rem; width: 1.5rem; color: white;" />
                </div>
                <div>
                    <h2 style="font-size: 1.25rem; font-weight: 600; color: white; margin: 0; line-height: 1.2;">
                        Bienvenido, {{ filament()->auth()->user()->name }}
                    </h2>
                    <p style="font-size: 0.875rem; color: #e0e7ff; margin: 0; margin-top: 0.25rem;">
                        San Julián CMMS - Panel de Control
                    </p>
                </div>
            </div>
            <div class="welcome-buttons">
                <x-filament::button
                    color="gray"
                    icon="heroicon-m-calendar-days"
                    tag="a"
                    size="sm"
                    href="{{ url('/admin/calendario-mantenciones') }}"
                    style="background-color: rgba(255, 255, 255, 0.1); color: white; border: none;"
                >
                    Calendario
                </x-filament::button>
                <x-filament::button
                    color="gray"
                    icon="heroicon-m-plus"
                    tag="a"
                    size="sm"
                    href="{{ url('/admin/mantencions/create') }}"
                    style="background-color: white; color: #4f46e5; border: none;"
                >
                    Nueva Orden
                </x-filament::button>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
