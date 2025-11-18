<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sankrypt - Ultimate API Security Solution</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s ease forwards;
        }
        
        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .delay-200 {
            animation-delay: 0.2s;
        }
        
        .delay-400 {
            animation-delay: 0.4s;
        }
        
        .delay-600 {
            animation-delay: 0.6s;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="text-2xl font-bold gradient-text">SANKRYPT</div>
                <div class="flex space-x-4">
                    <a href="#features" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        Features
                    </a>
                    <a href="#api" class="bg-gradient-to-r from-purple-600 to-blue-500 text-white px-4 py-2 rounded-md text-sm font-medium hover:shadow-lg transition-all">
                        API Docs
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg text-white pt-24 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-6 fade-in-up">
                Ultimate API Security Solution
            </h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto fade-in-up delay-200">
                Secure, scalable, and developer-friendly API authentication system with advanced encryption and monitoring
            </p>
            <a href="#api" class="inline-block bg-white text-purple-600 px-8 py-4 rounded-full font-semibold hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 fade-in-up delay-400">
                Explore API
            </a>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="fade-in-up">
                    <div class="text-4xl md:text-5xl font-bold gradient-text mb-2" id="apiCalls">0</div>
                    <div class="text-gray-600 font-medium">API Calls Secured</div>
                </div>
                <div class="fade-in-up delay-200">
                    <div class="text-4xl md:text-5xl font-bold gradient-text mb-2" id="activeUsers">0</div>
                    <div class="text-gray-600 font-medium">Active Users</div>
                </div>
                <div class="fade-in-up delay-400">
                    <div class="text-4xl md:text-5xl font-bold gradient-text mb-2">99.9%</div>
                    <div class="text-gray-600 font-medium">Uptime</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center mb-16 gradient-text">
                Why Choose Sankrypt?
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 fade-in-up">
                    <div class="text-4xl mb-4 gradient-text">🔒</div>
                    <h3 class="text-xl font-semibold mb-4 text-gray-900">Military-Grade Security</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Advanced encryption algorithms and secure key management to protect your data and API endpoints from unauthorized access.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 fade-in-up delay-200">
                    <div class="text-4xl mb-4 gradient-text">⚡</div>
                    <h3 class="text-xl font-semibold mb-4 text-gray-900">Lightning Fast</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Optimized for performance with minimal latency. Handle thousands of requests per second without compromising security.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 fade-in-up delay-400">
                    <div class="text-4xl mb-4 gradient-text">🔑</div>
                    <h3 class="text-xl font-semibold mb-4 text-gray-900">Easy Integration</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Simple RESTful API design with comprehensive documentation. Get started in minutes, not hours.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 fade-in-up">
                    <div class="text-4xl mb-4 gradient-text">📊</div>
                    <h3 class="text-xl font-semibold mb-4 text-gray-900">Real-time Monitoring</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Comprehensive access logs, rate limiting, and security analytics to monitor and protect your API ecosystem.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 fade-in-up delay-200">
                    <div class="text-4xl mb-4 gradient-text">🌐</div>
                    <h3 class="text-xl font-semibold mb-4 text-gray-900">Scalable Infrastructure</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Built on cloud-native architecture that scales automatically with your user base and traffic patterns.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 fade-in-up delay-400">
                    <div class="text-4xl mb-4 gradient-text">🛡️</div>
                    <h3 class="text-xl font-semibold mb-4 text-gray-900">DDoS Protection</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Advanced threat detection and mitigation to protect against malicious attacks and ensure service availability.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- API Section -->
    <section id="api" class="py-20 bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center mb-4">
                API Documentation
            </h2>
            <p class="text-xl text-center mb-12 text-gray-300 max-w-2xl mx-auto">
                Simple, secure, and powerful API endpoints for your applications
            </p>
            
            <div class="max-w-4xl mx-auto space-y-6">
                <!-- Endpoint 1 -->
                <div class="bg-gray-800 rounded-xl p-6 border-l-4 border-green-500 fade-in-up">
                    <div class="flex items-center mb-3">
                        <span class="bg-green-500 text-white px-3 py-1 rounded text-sm font-semibold mr-4">POST</span>
                        <span class="text-lg font-mono font-semibold">/api/register</span>
                    </div>
                    <p class="text-gray-300">Register new users with secure authentication keys and receive API credentials.</p>
                </div>

                <!-- Endpoint 2 -->
                <div class="bg-gray-800 rounded-xl p-6 border-l-4 border-blue-500 fade-in-up delay-200">
                    <div class="flex items-center mb-3">
                        <span class="bg-blue-500 text-white px-3 py-1 rounded text-sm font-semibold mr-4">POST</span>
                        <span class="text-lg font-mono font-semibold">/api/login</span>
                    </div>
                    <p class="text-gray-300">Authenticate users and receive secure access tokens for API requests.</p>
                </div>

                <!-- Endpoint 3 -->
                <div class="bg-gray-800 rounded-xl p-6 border-l-4 border-purple-500 fade-in-up delay-400">
                    <div class="flex items-center mb-3">
                        <span class="bg-purple-500 text-white px-3 py-1 rounded text-sm font-semibold mr-4">GET</span>
                        <span class="text-lg font-mono font-semibold">/api/user</span>
                    </div>
                    <p class="text-gray-300">Retrieve authenticated user profile information and security settings.</p>
                </div>

                <!-- Endpoint 4 -->
                <div class="bg-gray-800 rounded-xl p-6 border-l-4 border-yellow-500 fade-in-up delay-600">
                    <div class="flex items-center mb-3">
                        <span class="bg-yellow-500 text-white px-3 py-1 rounded text-sm font-semibold mr-4">POST</span>
                        <span class="text-lg font-mono font-semibold">/api/logout</span>
                    </div>
                    <p class="text-gray-300">Securely terminate user sessions and invalidate access tokens.</p>
                </div>

                <!-- Endpoint 5 -->
                <div class="bg-gray-800 rounded-xl p-6 border-l-4 border-red-500 fade-in-up delay-600">
                    <div class="flex items-center mb-3">
                        <span class="bg-red-500 text-white px-3 py-1 rounded text-sm font-semibold mr-4">POST</span>
                        <span class="text-lg font-mono font-semibold">/api/change-password</span>
                    </div>
                    <p class="text-gray-300">Update user authentication credentials securely with proper validation.</p>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="/api" class="inline-block bg-white text-gray-900 px-8 py-4 rounded-full font-semibold hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                    View Full API Documentation
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 border-t border-gray-800 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-400 mb-2">
                &copy; 2024 Sankrypt. All rights reserved. | Secure API Authentication Service
            </p>
            <p class="text-gray-500 text-sm">
                Built with ❤️ for developers worldwide
            </p>
        </div>
    </footer>

    <script>
        // Animate stats counter
        function animateStats() {
            const apiCalls = document.getElementById('apiCalls');
            const activeUsers = document.getElementById('activeUsers');
            
            let callsCount = 0;
            let usersCount = 0;
            
            const callsTarget = 12500;
            const usersTarget = 850;
            
            const incrementCalls = callsTarget / 100;
            const incrementUsers = usersTarget / 100;
            
            const timer = setInterval(() => {
                callsCount += incrementCalls;
                usersCount += incrementUsers;
                
                apiCalls.textContent = Math.floor(callsCount).toLocaleString();
                activeUsers.textContent = Math.floor(usersCount);
                
                if (callsCount >= callsTarget && usersCount >= usersTarget) {
                    clearInterval(timer);
                    apiCalls.textContent = callsTarget.toLocaleString();
                    activeUsers.textContent = usersTarget;
                }
            }, 20);
        }

        // Start animation when stats section is in view
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateStats();
                    statsObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        statsObserver.observe(document.querySelector('.bg-white'));

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add scroll animation for feature cards
        const featureObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in-up');
                    featureObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.bg-white.rounded-2xl').forEach(card => {
            featureObserver.observe(card);
        });
    </script>
</body>
</html>