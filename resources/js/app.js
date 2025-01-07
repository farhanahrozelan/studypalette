import './bootstrap';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';


document.addEventListener('DOMContentLoaded', function () {
    // Initialize Calendar
    const calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        const calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin],
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek',
            },
        });
        calendar.render();
    }

    // Initialize Flashcards
    const flashcards = document.querySelectorAll('.flashcard');
    if (flashcards.length > 0) {
        let currentIndex = 0;

        const prevButton = document.getElementById('prev');
        const nextButton = document.getElementById('next');

        if (prevButton && nextButton) {
            // Flip flashcard on click
            flashcards.forEach((card) => {
                card.addEventListener('click', () => {
                    card.classList.toggle('flipped');
                });
            });

            // Show the next flashcard
            nextButton.addEventListener('click', () => {
                flashcards[currentIndex].classList.remove('active');
                currentIndex++;
                flashcards[currentIndex].classList.add('active');
                updateButtons();
            });

            // Show the previous flashcard
            prevButton.addEventListener('click', () => {
                flashcards[currentIndex].classList.remove('active');
                currentIndex--;
                flashcards[currentIndex].classList.add('active');
                updateButtons();
            });

            // Update navigation button states
            function updateButtons() {
                prevButton.disabled = currentIndex === 0;
                nextButton.disabled = currentIndex === flashcards.length - 1;
            }

            // Initialize button states
            updateButtons();
        } else {
            console.warn('Navigation buttons (prev, next) not found.');
        }
    } else {
        console.warn('No flashcards found in the DOM.');
    }
});
