<script>
    // ── Mobile Sidebar toggle ──────────────────────────────
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const menuBtn = document.getElementById('menuBtn');
    const closeBtn = document.getElementById('closeBtn');

    function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    menuBtn.addEventListener('click', openSidebar);
    closeBtn.addEventListener('click', closeSidebar);
    overlay.addEventListener('click', closeSidebar);
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) closeSidebar();
    });

    // ── Sales Chart ────────────────────────────────────────
    new Chart(document.getElementById('salesChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: ['Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb'],
            datasets: [{
                data: [45000, 52000, 49000, 60000, 63000, 61000, 70000],
                borderColor: '#8B5CF6',
                backgroundColor: 'rgba(139,92,246,0.08)',
                borderWidth: 2.5,
                pointBackgroundColor: '#8B5CF6',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 10
                        },
                        color: '#9CA3AF'
                    }
                },
                y: {
                    grid: {
                        color: '#F3F4F6'
                    },
                    ticks: {
                        font: {
                            size: 10
                        },
                        color: '#9CA3AF',
                        callback: v => v >= 1000 ? (v / 1000) + 'k' : v
                    },
                    border: {
                        display: false
                    }
                }
            }
        }
    });

    // ── Category Chart ─────────────────────────────────────
    new Chart(document.getElementById('categoryChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Women Fashion', 'Men Fashion', 'Electronics', 'Home & Kitchen', 'Others'],
            datasets: [{
                data: [35, 25, 18, 14, 8],
                backgroundColor: ['#7C3AED', '#EC4899', '#F59E0B', '#10B981', '#E5E7EB'],
                borderWidth: 0,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.label}: ${ctx.parsed}%`
                    }
                }
            }
        }
    });
</script>

@stack('scripts')
