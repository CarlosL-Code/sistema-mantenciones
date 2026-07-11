<x-filament-widgets::widget>
    <x-filament::section class="overflow-hidden">
        <style>
            /* Estilos premium para hacer el calendario más llamativo */
            .fc-theme-standard .fc-scrollgrid {
                border: 1px solid #e2e8f0;
                border-radius: 0.75rem;
                overflow: hidden;
            }
            .fc-header-toolbar {
                padding: 0.5rem 0;
            }
        :root {
            --fc-button-bg-color: #4f46e5;
            --fc-button-border-color: #4f46e5;
            --fc-button-hover-bg-color: #4338ca;
            --fc-button-hover-border-color: #4338ca;
            --fc-button-active-bg-color: #3730a3;
            --fc-button-active-border-color: #3730a3;
        }

        .fc-toolbar-title {
                font-size: 1.25rem !important;
                font-weight: 700 !important;
                color: #1e293b;
            }
            .fc-daygrid-event {
                border-radius: 4px;
                padding: 2px 4px;
                font-size: 0.75rem;
                font-weight: 600;
                border: none !important;
                box-shadow: 0 1px 2px rgba(0,0,0,0.1);
                transition: transform 0.1s;
            }
            .fc-daygrid-event:hover {
                transform: scale(1.02);
                cursor: pointer;
            }
            .fc-col-header-cell {
                background-color: #f8fafc;
                padding: 0.5rem 0 !important;
            }
            .fc-day-today {
                background-color: #f0fdf4 !important; /* Verde muy claro para resaltar hoy */
            }
            
            /* Responsive Design for Mobile */
            @media (max-width: 768px) {
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
                    font-size: 0.65rem;
                    white-space: normal;
                }
            }
        </style>
        
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
            <h2 style="font-size: 1.25rem; font-weight: 800; color: #4f46e5; display: flex; align-items: center; gap: 0.5rem; margin: 0;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 24px; height: 24px; flex-shrink: 0;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Calendario de Mantenimiento</span>
            </h2>
        </div>
        
        <!-- FullCalendar Container -->
        <div class="w-full overflow-x-auto">
            <div 
                x-data="{
                    events: @js($this->getEvents()),
                    init() {
                        if (typeof FullCalendar === 'undefined') {
                            let script = document.createElement('script');
                            script.src = 'https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js';
                            script.onload = () => this.renderCalendar();
                            document.head.appendChild(script);
                        } else {
                            this.renderCalendar();
                        }
                    },
                    renderCalendar() {
                        let calendar = new FullCalendar.Calendar(this.$refs.calendarEl, {
                            initialView: window.innerWidth < 768 ? 'listMonth' : 'dayGridMonth',
                            locale: 'es',
                            height: window.innerWidth < 768 ? 'auto' : 450, // Altura adaptable
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
                            events: this.events,
                            eventClick: function(info) {
                                if (info.event.id) {
                                    $wire.mountAction('viewMantencion', { record: info.event.id });
                                    info.jsEvent.preventDefault();
                                } else if (info.event.url) {
                                    window.open(info.event.url, '_self');
                                    info.jsEvent.preventDefault();
                                }
                            }
                        });
                        calendar.render();
                    }
                }"
                wire:ignore
                class="mt-2"
            >
                <div x-ref="calendarEl" class="w-full min-w-[300px]"></div>
            </div>
        </div>
        <x-filament-actions::modals />
    </x-filament::section>
</x-filament-widgets::widget>
