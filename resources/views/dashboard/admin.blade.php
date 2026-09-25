<x-app-layout>

    <style>
        /* =========================================================
           DASHBOARD
        ========================================================== */

        .vivio-dashboard {
            min-height: 100vh;
            background: #f5f9fc;
            direction: rtl;
            font-family: 'Cairo', 'Tajawal', sans-serif;
        }

        .vivio-container {
            width: min(1280px, calc(100% - 48px));
            margin: 0 auto;
        }

        /* =========================================================
           HERO
        ========================================================== */

        .vivio-hero {
            position: relative;
            overflow: hidden;
            width: 100%;
            margin-top: 0;
            background:
                linear-gradient(
                    110deg,
                    #eef8ff 0%,
                    #ffffff 48%,
                    #f0faf5 100%
                );
        }

        .vivio-hero-inner {
            min-height: 310px;
            display: grid;
            width: min(1280px, calc(100% - 48px));
            margin: 0 auto;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            align-items: center;
            gap: 28px;
            padding: 48px 0;
            direction: ltr;
        }

        .vivio-hero-content {
            text-align: right;
            order: 2;
            direction: rtl;
        }

        .vivio-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 14px;
            border-radius: 999px;
            background: #e9f7ef;
            color: #299653;
            font-size: 12px;
            font-weight: 800;
        }

        .vivio-hero-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #2fa653;
        }

        .vivio-hero-title {
            margin: 16px 0 0;
            color: #123b63;
            font-size: 42px;
            line-height: 1.25;
            font-weight: 900;
        }

        .vivio-hero-title span {
            color: #123b63;
        }

        .vivio-hero-description {
            max-width: 570px;
            margin-top: 14px;
            color: #688097;
            font-size: 15px;
            line-height: 2;
        }

        .vivio-hero-actions {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 12px;
            margin-top: 22px;
        }

        .vivio-btn-green,
        .vivio-btn-outline {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 48px;
            padding: 0 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 800;
            text-decoration: none;
            transition: all .2s ease;
        }

        .vivio-btn-green {
            background: #2fa653;
            color: white;
            box-shadow: 0 7px 18px rgba(47, 166, 83, .18);
        }

        .vivio-btn-green:hover {
            background: #278e48;
            transform: translateY(-1px);
        }

        .vivio-btn-outline {
            background: white;
            color: #2169b7;
            border: 1px solid #2c7bd9;
        }

        .vivio-btn-outline:hover {
            background: #f1f7fd;
        }

        /* HERO VISUAL */

        .vivio-hero-visual {
            position: relative;
            min-height: 320px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            order: 1;
        }

        .vivio-hero-image {
            display: block;
            width: 100%;
            max-width: 560px;
            max-height: 360px;
            object-fit: contain;
            object-position: left center;
            border: 0;
            border-radius: 0;
            box-shadow: none;
            outline: 0;
        }

        /* =========================================================
           MAIN STATISTICS
        ========================================================== */

        .vivio-section {
            margin-top: 22px;
        }

        .vivio-main-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
        }

        .vivio-stat-card {
            min-width: 0;
            min-height: 158px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 22px;
            background: white;
            border: 1px solid #e5edf3;
            border-radius: 18px;
            box-shadow: 0 7px 20px rgba(20, 55, 80, .045);
            transition: all .2s ease;
        }

        .vivio-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(20, 55, 80, .08);
        }

        .vivio-stat-info {
            min-width: 0;
            text-align: right;
        }

        .vivio-stat-title {
            color: #637a90;
            font-size: 14px;
            font-weight: 800;
        }

        .vivio-stat-number {
            margin-top: 7px;
            color: #123b63;
            font-size: 36px;
            line-height: 1;
            font-weight: 900;
        }

        .vivio-stat-description {
            margin-top: 10px;
            color: #91a0af;
            font-size: 11px;
            line-height: 1.7;
        }

        .vivio-stat-icon {
            width: 58px;
            height: 58px;
            flex: 0 0 58px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 17px;
        }

        .vivio-stat-icon svg {
            width: 29px;
            height: 29px;
        }

        .icon-blue {
            background: #edf6ff;
            color: #2174c8;
        }

        .icon-green {
            background: #eaf8f0;
            color: #2d9d58;
        }

        .icon-orange {
            background: #fff4e8;
            color: #e78a16;
        }

        .icon-purple {
            background: #f1efff;
            color: #7061d8;
        }

        /* =========================================================
           HORIZONTAL SUMMARY
        ========================================================== */

        .vivio-summary {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            min-height: 106px;
            overflow: hidden;
            background: white;
            border: 1px solid #e5edf3;
            border-radius: 18px;
            box-shadow: 0 7px 20px rgba(20, 55, 80, .045);
        }

        .vivio-summary-item {
            min-width: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 13px;
            padding: 18px;
            border-left: 1px solid #e5edf3;
        }

        .vivio-summary-item:last-child {
            border-left: none;
        }

        .vivio-summary-icon {
            width: 46px;
            height: 46px;
            flex: 0 0 46px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
        }

        .vivio-summary-icon svg {
            width: 23px;
            height: 23px;
        }

        .vivio-summary-number {
            color: #123b63;
            font-size: 24px;
            line-height: 1;
            font-weight: 900;
        }

        .vivio-summary-label {
            margin-top: 5px;
            color: #71869a;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        /* =========================================================
           ANALYTICS
        ========================================================== */

        .vivio-analytics {
            display: grid;
            grid-template-columns: minmax(0, 1.55fr) minmax(340px, 1fr);
            gap: 20px;
            align-items: stretch;
        }

        .vivio-panel {
            min-width: 0;
            background: white;
            border: 1px solid #e5edf3;
            border-radius: 18px;
            box-shadow: 0 7px 20px rgba(20, 55, 80, .045);
        }

        .vivio-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 22px 24px 12px;
        }

        .vivio-panel-label {
            color: #2fa653;
            font-size: 11px;
            font-weight: 800;
        }

        .vivio-panel-title {
            margin-top: 4px;
            color: #123b63;
            font-size: 21px;
            font-weight: 900;
        }

        .vivio-panel-subtitle {
            margin-top: 4px;
            color: #8999a9;
            font-size: 11px;
        }

        .vivio-panel-icon {
            width: 45px;
            height: 45px;
            flex: 0 0 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: #eaf8f0;
            color: #2fa653;
        }

        /* =========================================================
           CHART
        ========================================================== */

        .vivio-chart-wrapper {
            height: 300px;
            padding: 5px 20px 20px;
        }

        .vivio-chart-wrapper svg {
            width: 100%;
            height: 100%;
            display: block;
        }

        /* =========================================================
           ACTIVITIES
        ========================================================== */

        .vivio-activities {
            padding: 0 22px 12px;
        }

        .vivio-activity {
            min-height: 65px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid #edf1f5;
        }

        .vivio-activity:last-child {
            border-bottom: none;
        }

        .vivio-activity-icon {
            width: 40px;
            height: 40px;
            flex: 0 0 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
        }

        .vivio-activity-icon svg {
            width: 19px;
            height: 19px;
        }

        .vivio-activity-content {
            flex: 1;
            min-width: 0;
            text-align: right;
        }

        .vivio-activity-title {
            color: #294465;
            font-size: 13px;
            font-weight: 800;
        }

        .vivio-activity-subtitle {
            margin-top: 2px;
            color: #9aa8b6;
            font-size: 10px;
        }

        .vivio-activity-time {
            flex: 0 0 auto;
            color: #8293a4;
            font-size: 10px;
            font-weight: 700;
            direction: rtl;
        }

        .vivio-all-activities {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 10px;
            color: #2878d8;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
        }

        .vivio-all-activities:hover {
            color: #155da9;
        }

        /* =========================================================
           MOBILE
        ========================================================== */

        @media (max-width: 1100px) {

            .vivio-container {
                width: min(100% - 32px, 900px);
            }

            .vivio-main-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .vivio-hero-inner {
                width: min(100% - 32px, 900px);
                grid-template-columns: 1fr;
            }

            .vivio-hero-content {
                order: 1;
            }

            .vivio-hero-visual {
                justify-content: center;
                order: 2;
            }

            .vivio-analytics {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 760px) {

            .vivio-container {
                width: calc(100% - 24px);
            }

            .vivio-hero {
                margin-top: 0;
            }

            .vivio-hero-inner {
                width: calc(100% - 24px);
                padding: 26px 20px;
                min-height: auto;
                gap: 24px;
            }

            .vivio-hero-title {
                font-size: 32px;
            }

            .vivio-hero-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .vivio-btn-green,
            .vivio-btn-outline {
                width: 100%;
            }

            .vivio-hero-visual {
                min-height: 180px;
            }

            .vivio-hero-image {
                width: 100%;
                max-height: 260px;
                object-position: center;
            }

            .vivio-main-stats {
                grid-template-columns: 1fr;
            }

            .vivio-summary {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .vivio-summary-item:nth-child(2) {
                border-left: none;
            }

            .vivio-summary-item:nth-child(1),
            .vivio-summary-item:nth-child(2) {
                border-bottom: 1px solid #e5edf3;
            }

            .vivio-summary-item {
                min-height: 92px;
            }

            .vivio-panel-header {
                padding: 18px 18px 10px;
            }

            .vivio-chart-wrapper {
                height: 250px;
                padding: 5px 12px 15px;
            }

            .vivio-activities {
                padding: 0 16px 10px;
            }
        }

        @media (max-width: 480px) {

            .vivio-summary {
                grid-template-columns: 1fr;
            }

            .vivio-summary-item,
            .vivio-summary-item:nth-child(1),
            .vivio-summary-item:nth-child(2) {
                border-left: none;
                border-bottom: 1px solid #e5edf3;
            }

            .vivio-summary-item:last-child {
                border-bottom: none;
            }

            .vivio-stat-card {
                min-height: 135px;
                padding: 18px;
            }

            .vivio-stat-number {
                font-size: 31px;
            }

            .vivio-panel-title {
                font-size: 19px;
            }

            .vivio-activity {
                min-height: 62px;
            }
        }
    </style>


    <div class="vivio-dashboard">

        {{-- =====================================================
             HERO
        ====================================================== --}}

        <section class="vivio-hero">
            <div class="vivio-hero-inner">

                    {{-- VISUAL --}}
                    <div class="vivio-hero-visual">
                        <img
                            src="{{ asset('images/image-transparent.png') }}"
                            alt="واجهة إدارة المشفى الإلكترونية"
                            class="vivio-hero-image"
                        >

                    </div>


                    {{-- CONTENT --}}
                    <div class="vivio-hero-content">

                        <span class="vivio-hero-badge">
                            <span class="vivio-hero-dot"></span>
                            نظام إدارة المشفى الإلكتروني
                        </span>

                        <h1 class="vivio-hero-title">
                            نظام إدارة
                            <br>
                            <span>المشفى الإلكتروني</span>
                        </h1>

                        <p class="vivio-hero-description">
                            إدارة سهلة لعمليات المشفى الأساسية،
                            من المرضى والأطباء إلى المواعيد والتقارير
                            في مكان واحد.
                        </p>

                        <div class="vivio-hero-actions">

                            <a href="{{ route('reports.index') }}"
                               class="vivio-btn-green">
                                <span>ابدأ الآن</span>
                                <span>←</span>
                            </a>

                            <a href="{{ route('patients.index') }}"
                               class="vivio-btn-outline">
                                <span>تعرّف على النظام</span>
                                <span>←</span>
                            </a>

                        </div>

                    </div>

            </div>
        </section>


        {{-- =====================================================
             MAIN STATISTICS
        ====================================================== --}}

        <section class="vivio-container vivio-section">

            <div class="vivio-main-stats">

                {{-- PATIENTS --}}
                <a href="{{ route('patients.index') }}"
                   class="vivio-stat-card"
                   style="text-decoration:none;">

                    <div class="vivio-stat-info">

                        <div class="vivio-stat-title">
                            المرضى
                        </div>

                        <div class="vivio-stat-number">
                            {{ $patientCount }}
                        </div>

                        <div class="vivio-stat-description">
                            إدارة بيانات المرضى ومتابعتهم
                        </div>

                    </div>

                    <div class="vivio-stat-icon icon-blue">

                        <svg fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path
                                d="M16 19v-1a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v1"
                                stroke-width="1.8"
                                stroke-linecap="round"
                            />

                            <circle
                                cx="10"
                                cy="7"
                                r="3"
                                stroke-width="1.8"
                            />

                            <path
                                d="M20 19v-1a4 4 0 0 0-3-3.87M16 4.13a4 4 0 0 1 0 7.75"
                                stroke-width="1.8"
                            />

                        </svg>

                    </div>

                </a>


                {{-- DOCTORS --}}
                <a href="{{ route('doctors.index') }}"
                   class="vivio-stat-card"
                   style="text-decoration:none;">

                    <div class="vivio-stat-info">

                        <div class="vivio-stat-title">
                            الأطباء
                        </div>

                        <div class="vivio-stat-number">
                            {{ $doctorCount }}
                        </div>

                        <div class="vivio-stat-description">
                            إدارة الفريق الطبي والتخصصات
                        </div>

                    </div>

                    <div class="vivio-stat-icon icon-green">

                        <svg fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <circle
                                cx="12"
                                cy="8"
                                r="3"
                                stroke-width="1.8"
                            />

                            <path
                                d="M5 21v-2a5 5 0 0 1 10 0v2"
                                stroke-width="1.8"
                            />

                            <path
                                d="M18 7v6M15 10h6"
                                stroke-width="1.8"
                                stroke-linecap="round"
                            />

                        </svg>

                    </div>

                </a>


                {{-- APPOINTMENTS --}}
                <a href="{{ route('appointments.index') }}"
                   class="vivio-stat-card"
                   style="text-decoration:none;">

                    <div class="vivio-stat-info">

                        <div class="vivio-stat-title">
                            المواعيد
                        </div>

                        <div class="vivio-stat-number">
                            {{ $appointmentCount }}
                        </div>

                        <div class="vivio-stat-description">
                            حجز ومتابعة المواعيد الطبية
                        </div>

                    </div>

                    <div class="vivio-stat-icon icon-orange">

                        <svg fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <rect
                                x="3"
                                y="5"
                                width="18"
                                height="16"
                                rx="2"
                                stroke-width="1.8"
                            />

                            <path
                                d="M8 3v4M16 3v4M3 10h18"
                                stroke-width="1.8"
                                stroke-linecap="round"
                            />

                            <path
                                d="M8 14h3v3H8z"
                                stroke-width="1.5"
                            />

                        </svg>

                    </div>

                </a>


                {{-- DEPARTMENTS --}}
                <a href="{{ route('departments.index') }}"
                   class="vivio-stat-card"
                   style="text-decoration:none;">

                    <div class="vivio-stat-info">

                        <div class="vivio-stat-title">
                            الأقسام
                        </div>

                        <div class="vivio-stat-number">
                            {{ $departmentCount }}
                        </div>

                        <div class="vivio-stat-description">
                            تنظيم أقسام المشفى والخدمات
                        </div>

                    </div>

                    <div class="vivio-stat-icon icon-purple">

                        <svg fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path
                                d="M4 20V7.5A1.5 1.5 0 0 1 5.5 6H8V4.5A1.5 1.5 0 0 1 9.5 3h5A1.5 1.5 0 0 1 16 4.5V6h2.5A1.5 1.5 0 0 1 20 7.5V20"
                                stroke-width="1.8"
                            />

                            <path
                                d="M8 10h.01M12 10h.01M16 10h.01M8 14h.01M12 14h.01M16 14h.01"
                                stroke-width="2"
                                stroke-linecap="round"
                            />

                        </svg>

                    </div>

                </a>

            </div>

        </section>


        {{-- =====================================================
             ANALYTICS + ACTIVITIES
        ====================================================== --}}

        <section class="vivio-container vivio-section"
                 style="padding-bottom: 35px;">

            <div class="vivio-analytics">


                {{-- =================================================
                     CHART
                ================================================== --}}

                <div class="vivio-panel">

                    <div class="vivio-panel-header">

                        <div style="text-align:right;">

                            <div class="vivio-panel-label">
                                ملخص الموارد
                            </div>

                            <div class="vivio-panel-title">
                                إحصائيات اليوم
                            </div>

                            <div class="vivio-panel-subtitle">
                                مؤشرات مباشرة مبنية على بيانات النظام الحالية
                            </div>

                        </div>

                        <div class="vivio-panel-icon">

                            <svg
                                width="23"
                                height="23"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path
                                    d="M4 19V5M4 19h16"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                />

                                <path
                                    d="M8 16v-4M12 16V8M16 16v-6"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                />

                            </svg>

                        </div>

                    </div>


                    <div class="vivio-chart-wrapper">

                        <svg
                            viewBox="0 0 760 280"
                            preserveAspectRatio="none"
                            aria-label="إحصائيات اليوم">

                            <defs>

                                <linearGradient
                                    id="vivioChartGradient"
                                    x1="0"
                                    y1="0"
                                    x2="0"
                                    y2="1">

                                    <stop
                                        offset="0%"
                                        stop-color="#76b7f4"
                                        stop-opacity=".42"
                                    />

                                    <stop
                                        offset="100%"
                                        stop-color="#76b7f4"
                                        stop-opacity=".04"
                                    />

                                </linearGradient>

                            </defs>


                            {{-- GRID --}}

                            <g
                                stroke="#dce9f4"
                                stroke-width="1">

                                <line x1="45" y1="25" x2="740" y2="25"/>
                                <line x1="45" y1="80" x2="740" y2="80"/>
                                <line x1="45" y1="135" x2="740" y2="135"/>
                                <line x1="45" y1="190" x2="740" y2="190"/>
                                <line x1="45" y1="235" x2="740" y2="235"/>

                            </g>


                            {{-- AREA --}}

                            <path
                                d="
                                    M45 205
                                    C95 180 120 170 160 175
                                    S220 135 265 145
                                    S325 105 365 130
                                    S430 55 475 70
                                    S545 135 590 115
                                    S675 95 740 120
                                    L740 235
                                    L45 235
                                    Z
                                "
                                fill="url(#vivioChartGradient)"
                            />


                            {{-- LINE --}}

                            <path
                                d="
                                    M45 205
                                    C95 180 120 170 160 175
                                    S220 135 265 145
                                    S325 105 365 130
                                    S430 55 475 70
                                    S545 135 590 115
                                    S675 95 740 120
                                "
                                fill="none"
                                stroke="#2878d8"
                                stroke-width="4"
                                stroke-linecap="round"
                            />


                            {{-- POINTS --}}

                            <g
                                fill="#2878d8"
                                stroke="white"
                                stroke-width="3">

                                <circle cx="45" cy="205" r="6"/>
                                <circle cx="160" cy="175" r="6"/>
                                <circle cx="265" cy="145" r="6"/>
                                <circle cx="365" cy="130" r="6"/>
                                <circle cx="475" cy="70" r="6"/>
                                <circle cx="590" cy="115" r="6"/>
                                <circle cx="740" cy="120" r="6"/>

                            </g>


                            {{-- DAYS --}}

                            <g
                                fill="#8194aa"
                                font-size="14"
                                font-family="Cairo, sans-serif">

                                <text
                                    x="45"
                                    y="268"
                                    text-anchor="middle">
                                    السبت
                                </text>

                                <text
                                    x="160"
                                    y="268"
                                    text-anchor="middle">
                                    الأحد
                                </text>

                                <text
                                    x="265"
                                    y="268"
                                    text-anchor="middle">
                                    الإثنين
                                </text>

                                <text
                                    x="365"
                                    y="268"
                                    text-anchor="middle">
                                    الثلاثاء
                                </text>

                                <text
                                    x="475"
                                    y="268"
                                    text-anchor="middle">
                                    الأربعاء
                                </text>

                                <text
                                    x="590"
                                    y="268"
                                    text-anchor="middle">
                                    الخميس
                                </text>

                                <text
                                    x="740"
                                    y="268"
                                    text-anchor="middle">
                                    الجمعة
                                </text>

                            </g>

                        </svg>

                    </div>

                </div>


                {{-- =================================================
                     RECENT ACTIVITIES
                ================================================== --}}

                <div class="vivio-panel">

                    <div class="vivio-panel-header">

                        <div style="text-align:right;">

                            <div class="vivio-panel-label">
                                المتابعة اليومية
                            </div>

                            <div class="vivio-panel-title">
                                آخر الأنشطة
                            </div>

                            <div class="vivio-panel-subtitle">
                                أحدث العمليات في النظام
                            </div>

                        </div>

                        <div class="vivio-panel-icon">

                            <svg
                                width="23"
                                height="23"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                    stroke-width="1.8"
                                />

                                <path
                                    d="M12 7v5l3 2"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                />

                            </svg>

                        </div>

                    </div>


                    @php

                        $activities = [

                            [
                                'title' => 'تم تسجيل مريض جديد',
                                'subtitle' => 'مراجعة عامة',
                                'time' => '10:24 ص',
                                'type' => 'patient'
                            ],

                            [
                                'title' => 'تمت إضافة طبيب جديد',
                                'subtitle' => 'أحمد محمد علي',
                                'time' => '09:15 ص',
                                'type' => 'doctor'
                            ],

                            [
                                'title' => 'تم إصدار تقرير طبي',
                                'subtitle' => 'تقرير العيادة الداخلية',
                                'time' => '08:40 ص',
                                'type' => 'report'
                            ],

                            [
                                'title' => 'تم تحديث بيانات المريض',
                                'subtitle' => 'سارة أحمد',
                                'time' => '08:12 ص',
                                'type' => 'update'
                            ],

                        ];

                    @endphp


                    <div class="vivio-activities">

                        @foreach($activities as $activity)

                            <div class="vivio-activity">

                                {{-- ICON --}}

                                <div
                                    class="vivio-activity-icon
                                    @if($activity['type'] === 'patient')
                                        icon-green
                                    @elseif($activity['type'] === 'doctor')
                                        icon-blue
                                    @elseif($activity['type'] === 'report')
                                        icon-purple
                                    @else
                                        icon-green
                                    @endif">

                                    @if($activity['type'] === 'patient')

                                        <svg
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24">

                                            <circle
                                                cx="12"
                                                cy="8"
                                                r="3"
                                                stroke-width="1.8"
                                            />

                                            <path
                                                d="M5 21v-2a7 7 0 0 1 14 0v2"
                                                stroke-width="1.8"
                                            />

                                        </svg>

                                    @elseif($activity['type'] === 'doctor')

                                        <svg
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24">

                                            <circle
                                                cx="12"
                                                cy="8"
                                                r="3"
                                                stroke-width="1.8"
                                            />

                                            <path
                                                d="M5 21v-2a7 7 0 0 1 14 0v2"
                                                stroke-width="1.8"
                                            />

                                            <path
                                                d="M18 5v6M15 8h6"
                                                stroke-width="1.8"
                                                stroke-linecap="round"
                                            />

                                        </svg>

                                    @elseif($activity['type'] === 'report')

                                        <svg
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24">

                                            <path
                                                d="M6 3h9l4 4v14H6z"
                                                stroke-width="1.8"
                                            />

                                            <path
                                                d="M14 3v5h5M9 14h6M9 17h4"
                                                stroke-width="1.8"
                                                stroke-linecap="round"
                                            />

                                        </svg>

                                    @else

                                        <svg
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24">

                                            <path
                                                d="M20 12a8 8 0 1 1-2.34-5.66"
                                                stroke-width="1.8"
                                                stroke-linecap="round"
                                            />

                                            <path
                                                d="M20 5v5h-5"
                                                stroke-width="1.8"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />

                                        </svg>

                                    @endif

                                </div>


                                {{-- TEXT --}}

                                <div class="vivio-activity-content">

                                    <div class="vivio-activity-title">
                                        {{ $activity['title'] }}
                                    </div>

                                    <div class="vivio-activity-subtitle">
                                        {{ $activity['subtitle'] }}
                                    </div>

                                </div>


                                {{-- TIME --}}

                                <div class="vivio-activity-time">
                                    {{ $activity['time'] }}
                                </div>

                            </div>

                        @endforeach


                        <a
                            href="{{ route('reports.index') }}"
                            class="vivio-all-activities">

                            عرض جميع الأنشطة
                            <span>←</span>

                        </a>

                    </div>

                </div>

            </div>

        </section>

    </div>

</x-app-layout>