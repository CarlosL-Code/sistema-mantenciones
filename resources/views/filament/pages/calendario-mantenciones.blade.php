<x-filament-panels::page>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>

    <style>
        /* Premium Calendar Styles */
        .premium-calendar-container {
            background-color: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            padding: 1.5rem;
            border: 1px solid #f3f4f6;
        }

        .dark .premium-calendar-container {
            background-color: #1f2937;
            border-color: #374151;
        }

        /* FullCalendar Overrides */
        .fc-theme-standard .fc-scrollgrid {
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            overflow: hidden;
        }
        
        .dark .fc-theme-standard .fc-scrollgrid {
            border-color: #374151;
        }

        .fc .fc-toolbar-title {
            font-size: 1.25rem !important;
            font-weight: 700 !important;
            color: #1e293b;
        }

        .dark .fc .fc-toolbar-title {
            color: #f9fafb;
        }

        :root {
            --fc-button-bg-color: #4f46e5;
            --fc-button-border-color: #4f46e5;
            --fc-button-hover-bg-color: #4338ca;
            --fc-button-hover-border-color: #4338ca;
            --fc-button-active-bg-color: #3730a3;
            --fc-button-active-border-color: #3730a3;
            --fc-today-bg-color: #f0fdf4;
        }

        .fc .fc-button-primary {
            font-weight: 500 !important;
            text-transform: capitalize !important;
        }

        .fc-col-header-cell {
            background-color: #f8fafc;
            padding: 0.5rem 0 !important;
        }

        .dark .fc-col-header-cell {
            background-color: #1f2937;
        }

        .fc-day-today {
            background-color: #f0fdf4 !important; /* Verde muy claro para resaltar hoy */
        }
        .dark .fc-day-today {
            background-color: #064e3b !important;
        }

        .fc-daygrid-event {
            border-radius: 4px !important;
            padding: 2px 4px !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            border: none !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            transition: transform 0.15s ease-in-out;
            cursor: pointer;
        }

        .fc-daygrid-event:hover {
            transform: scale(1.02);
        }

        .fc-event-main {
            color: #ffffff !important;
        }

        .legend-dot {
            height: 10px;
            width: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }

        .header-container {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
            gap: 1rem;
        }
        .header-legend {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            background-color: #ffffff;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }
        .dark .header-legend {
            background-color: #1f2937;
            border-color: #374151;
        }
        
        .fc-header-toolbar {
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        /* Responsive Design for Mobile */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                align-items: flex-start;
            }
            .header-legend {
                flex-wrap: wrap;
                width: 100%;
            }
            .fc-header-toolbar {
                flex-direction: column;
                gap: 0.5rem;
            }
            .fc-toolbar-chunk {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 0.25rem;
            }
            .fc-toolbar-title {
                font-size: 1.1rem !important;
                text-align: center;
            }
            .fc-daygrid-event {
                font-size: 0.65rem !important;
                white-space: normal;
            }
            .premium-calendar-container {
                padding: 0.5rem;
            }
        }
    </style>

    <div class="header-container">
        <div>
            <h2 style="font-size: 1.25rem; font-weight: 800; color: #4f46e5; display: flex; align-items: center; gap: 0.5rem; margin: 0; margin-bottom: 0.25rem;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 24px; height: 24px; flex-shrink: 0;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Calendario de Mantenimiento</span>
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Visualiza y gestiona las órdenes de trabajo programadas.</p>
        </div>
        <div class="header-legend">
            <span class="text-xs font-medium text-gray-700 dark:text-gray-300" style="display: flex; align-items: center;">
                <span class="legend-dot" style="background-color: #ef4444;"></span> Pendiente
            </span>
            <span class="text-xs font-medium text-gray-700 dark:text-gray-300" style="display: flex; align-items: center;">
                <span class="legend-dot" style="background-color: #eab308;"></span> En Proceso
            </span>
            <span class="text-xs font-medium text-gray-700 dark:text-gray-300" style="display: flex; align-items: center;">
                <span class="legend-dot" style="background-color: #22c55e;"></span> Completada
            </span>
        </div>
    </div>

    <div class="premium-calendar-container w-full min-w-0" wire:ignore>
        <div id="calendar" class="w-full min-w-0"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: window.innerWidth < 768 ? 'listMonth' : 'dayGridMonth',
                locale: 'es',
                height: window.innerWidth < 768 ? 'auto' : 450,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listMonth'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día',
                    list: 'Agenda'
                },
                events: @json($events),
                eventClick: function(info) {
                    if (info.event.url) {
                        window.open(info.event.url, '_self');
                        info.jsEvent.preventDefault();
                    }
                }
            });
            calendar.render();
            
            // Update calendar size when Filament sidebar expands/collapses
            if (window.ResizeObserver) {
                new ResizeObserver(function() {
                    calendar.updateSize();
                }).observe(calendarEl.parentElement);
            }
        });
    </script>
</x-filament-panels::page>
