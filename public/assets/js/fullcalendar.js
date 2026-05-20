const FullCalendar = {
    Calendar: class {
        constructor(el, options) {
            this.el = el;
            this.options = options;
        }
        render() {
            this.el.innerHTML = '';
            this.el.classList.add('custom-fc');
            
            const header = document.createElement('div');
            header.className = 'fc-header';
            header.innerHTML = `<button type="button">‹</button><span style="color:var(--ink);">Mai 2026</span><button type="button">›</button>`;
            this.el.appendChild(header);

            const table = document.createElement('table');
            table.className = 'fc-table';
            const days = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
            let html = '<thead><tr>' + days.map(d => `<th>${d}</th>`).join('') + '</tr></thead><tbody><tr>';
            
            // Le 1er Mai 2026 est un Vendredi (index 4 si Lundi=0)
            let startDay = 4; 
            for(let i=0; i<startDay; i++) html += '<td class="fc-empty"></td>';
            
            let currentLine = startDay;
            for(let day=1; day<=31; day++) {
                if (currentLine === 7) { html += '</tr><tr>'; currentLine = 0; }
                
                const dateStr = `2026-05-${day.toString().padStart(2, '0')}`;
                let eventsHtml = '';
                
                if (this.options.events) {
                    this.options.events.forEach(ev => {
                        if (dateStr >= ev.start && dateStr <= ev.end) {
                            eventsHtml += `<div class="fc-event" style="background:${ev.backgroundColor}">${ev.title}</div>`;
                        }
                    });
                }

                html += `<td class="fc-day" data-date="${dateStr}"><div class="fc-day-num">${day}</div>${eventsHtml}</td>`;
                currentLine++;
            }
            while(currentLine < 7) { html += '<td class="fc-empty"></td>'; currentLine++; }
            html += '</tr></tbody>';
            table.innerHTML = html;
            this.el.appendChild(table);

            // Gestion du clic pour remplir le formulaire
            let clickCount = 0;
            let firstDate = null;
            this.el.querySelectorAll('.fc-day').forEach(td => {
                td.addEventListener('click', () => {
                    const date = td.getAttribute('data-date');
                    clickCount++;
                    if (clickCount === 1) {
                        firstDate = date;
                        td.style.background = '#e8f4ec';
                        document.getElementById('start_date').value = date;
                    } else {
                        document.getElementById('end_date').value = date;
                        clickCount = 0;
                        this.render(); // Rafraîchit le visuel
                    }
                });
            });
        }
    }
};