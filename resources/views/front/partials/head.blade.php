<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - @yield('title')</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
            box-sizing: border-box;
        }

        body {
            background: #F3F2FA;
            margin: 0;
        }

        .top-banner {
            background: linear-gradient(90deg, #6D28D9 0%, #EC4899 100%);
        }

        .logo-text {
            background: linear-gradient(90deg, #7C3AED, #EC4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Sidebar */
        .sidebar {
            background: #fff;
            border-right: 1px solid #EDE9FE;
            transition: transform 0.3s ease;
        }

        /* Mobile overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            z-index: 40;
        }

        .sidebar-overlay.open {
            display: block;
        }

        /* On mobile sidebar is a fixed drawer */
        @media(max-width:767px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                width: 260px;
                z-index: 50;
                transform: translateX(-100%);
                overflow-y: auto;
            }

            .sidebar.open {
                transform: translateX(0);
            }
        }

        .nav-item {
            transition: all 0.18s;
            cursor: pointer;
        }

        .nav-item:hover {
            background: rgba(139, 92, 246, 0.08);
            color: #6D28D9;
        }

        .nav-item.active {
            background: rgba(139, 92, 246, 0.12);
            color: #6D28D9;
            font-weight: 600;
        }

        .stat-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(139, 92, 246, 0.13);
        }

        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .icon-users {
            background: linear-gradient(135deg, #3B82F6, #2563EB);
        }

        .icon-products {
            background: linear-gradient(135deg, #10B981, #059669);
        }

        .icon-orders {
            background: linear-gradient(135deg, #8B5CF6, #6D28D9);
        }

        .icon-revenue {
            background: linear-gradient(135deg, #F59E0B, #D97706);
        }

        .badge-up {
            color: #059669;
            background: #ECFDF5;
            border-radius: 20px;
            padding: 2px 8px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .search-bar {
            background: #F3F2FA;
            border: 1.5px solid #EDE9FE;
            transition: border-color 0.2s;
        }

        .search-bar:focus {
            outline: none;
            border-color: #8B5CF6;
            background: #fff;
        }

        .category-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            flex-shrink: 0;
        }

        .chart-container {
            position: relative;
            height: 200px;
        }

        /* Horizontal scroll for nav & table */
        .cat-nav {
            overflow-x: auto;
            scrollbar-width: none;
        }

        .cat-nav::-webkit-scrollbar {
            display: none;
        }

        .table-wrap {
            overflow-x: auto;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(14px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .fade-up {
            animation: fadeUp 0.4s ease both;
        }

        .d1 {
            animation-delay: .07s
        }

        .d2 {
            animation-delay: .14s
        }

        .d3 {
            animation-delay: .21s
        }

        .d4 {
            animation-delay: .28s
        }

        .d5 {
            animation-delay: .35s
        }

        .d6 {
            animation-delay: .42s
        }

        ::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #DDD6FE;
            border-radius: 4px;
        }
    </style>
</head>
