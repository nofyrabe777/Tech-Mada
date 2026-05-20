const FullCalendar = {
    Calendar: class {
        constructor(el, options) {
            this.el = el;
            this.options = options;
            // On initialise le calendrier sur le mois actuel (Mai 2026 par exemple)
            this.currentDate = new Date(2026, 4, 1); // 4 = Mai en JS (les mois vont de 0 à 11)
        }
        
        render() {
            this.el.innerHTML = '';
            this.el.classList.add('custom-fc');
            
            const year = this.currentDate.getFullYear();
            const month = this.currentDate.getMonth();
            
            // Liste des mois en français
            const moisNoms = [
                'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 
                'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
            ];
            
            // 1. Calcul du nombre de jours dans ce mois précis
            const totalDays = new Date(year, month + 1, 0).getDate();
            
            // 2. Trouver le jour de la semaine du 1er du mois (0 = Dimanche, 1 = Lundi...)
            let firstDayIndex = new Date(year, month, 1).getDay();
            // Convertir pour que Lundi = 0, Mardi = 1... Dimanche = 6
            let startDay = firstDayIndex === 0 ? 6 : firstDayIndex - 1;

            // 3. Rendu du Header avec les classes pour les boutons
            const header = document.createElement('div');
            header.className = 'fc-header';
            header.innerHTML = `
                <button type="button" class="btn-fc-prev">‹</button>
                <span style="color:var(--ink); font-weight: 600;">${moisNoms[month]} ${year}</span>
                <button type="button" class="btn-fc-next">›</button>
            `;
            this.el.appendChild(header);

            // 4. Construction de la table
            const table = document.createElement('table');
            table.className = 'fc-table';
            const days = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
            let html = '<thead><tr>' + days.map(d => `<th>${d}</th>`).join('') + '</tr></thead><tbody><tr>';
            
            // Cases vides du début du mois
            for(let i = 0; i < startDay; i++) html += '<td class="fc-empty"></td>';
            
            let currentLine = startDay;
            for(let day = 1; day <= totalDays; day++) {
                if (currentLine === 7) { html += '</tr><tr>'; currentLine = 0; }
                
                // Formatage de la date ISO YYYY-MM-DD
                const dateStr = `${year}-${(month + 1).toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
                let eventsHtml = '';
                
                // Injection des congés PHP s'ils correspondent à cette date
                if (this.options.events) {
                    this.options.events.forEach(ev => {
                        if (dateStr >= ev.start && dateStr <= ev.end) {
                            eventsHtml += `<div class="fc-event" style="background:${ev.backgroundColor || '#2d5a3d'}">${ev.title}</div>`;
                        }
                    });
                }

                html += `<td class="fc-day" data-date="${dateStr}"><div class="fc-day-num">${day}</div>${eventsHtml}</td>`;
                currentLine++;
            }
            
            // Cases vides de la fin du mois
            while(currentLine < 7) { html += '<td class="fc-empty"></td>'; currentLine++; }
            html += '</tr></tbody>';
            table.innerHTML = html;
            this.el.appendChild(table);

            // 5. ÉCOUTEURS D'ÉVÉNEMENTS
            
            // Bouton Mois Précédent
            this.el.querySelector('.btn-fc-prev').addEventListener('click', (e) => {
                e.preventDefault();
                this.currentDate.setMonth(this.currentDate.getMonth() - 1);
                this.render();
            });

            // Bouton Mois Suivant
            this.el.querySelector('.btn-fc-next').addEventListener('click', (e) => {
                e.preventDefault();
                this.currentDate.setMonth(this.currentDate.getMonth() + 1);
                this.render();
            });

            // Gestion du clic pour remplir le formulaire (Garde ton fonctionnement initial)
            let clickCount = 0;
            this.el.querySelectorAll('.fc-day').forEach(td => {
                td.addEventListener('click', () => {
                    const date = td.getAttribute('data-date');
                    clickCount++;
                    if (clickCount === 1) {
                        td.style.background = '#e8f4ec';
                        const startInput = document.getElementById('start_date');
                        if (startInput) startInput.value = date;
                    } else {
                        const endInput = document.getElementById('end_date');
                        if (endInput) endInput.value = date;
                        clickCount = 0;
                        this.render(); // Relance le rendu pour nettoyer la couleur temporaire
                    }
                });
            });
        }
    }
};