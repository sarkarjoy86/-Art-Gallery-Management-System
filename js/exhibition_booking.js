document.addEventListener('DOMContentLoaded', function () {
    const exhibitions = [
        { id: 1, title: 'Modern Art Exhibition', start_date: '2025-02-01', end_date: '2025-02-15', location: 'Gallery Hall 1' },
        { id: 2, title: 'Photography Exhibition', start_date: '2025-03-01', end_date: '2025-03-20', location: 'Gallery Hall 2' },
        { id: 3, title: 'Classic Art Exhibition', start_date: '2025-04-01', end_date: '2025-04-30', location: 'Gallery Hall 3' }
    ];

    const exhibitionContainer = document.querySelector('.exhibition-list'); // Container where exhibitions will be listed
    exhibitions.forEach(function (exhibition) {
        const exhibitionHTML = `
            <div class="exhibition-card">
                <h4>${exhibition.title}</h4>
                <p><strong>Location:</strong> ${exhibition.location}</p>
                <p><strong>Start Date:</strong> ${exhibition.start_date}</p>
                <p><strong>End Date:</strong> ${exhibition.end_date}</p>
                <button class="btn btn-book" data-exhibition-id="${exhibition.id}">Book Now</button>
            </div>
        `;
        exhibitionContainer.innerHTML += exhibitionHTML;
    });
});
