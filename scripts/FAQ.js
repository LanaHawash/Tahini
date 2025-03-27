const faqQuestions = document.querySelectorAll('.faq-question');

faqQuestions.forEach(question => {
    question.addEventListener('click', () => {
        // Find the answer element corresponding to this question
        const answer = question.nextElementSibling;
        const plusSign = question.querySelector('.plus');

        // Toggle the display of the answer and change the plus sign to minus
        if (answer.style.display === 'none' || answer.style.display === '') {
            answer.style.display = 'block';
            plusSign.textContent = '-'; // Change "+" to "-"
        } else {
            answer.style.display = 'none';
            plusSign.textContent = '+'; // Change "-" back to "+"
        }
    });
});