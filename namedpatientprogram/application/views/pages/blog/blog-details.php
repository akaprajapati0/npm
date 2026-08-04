<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $article['title'] ?> - News Details
    </title>
    <meta name="description" content="<?= strip_tags(word_limiter($article['description'], 30)) ?>">
    <meta name="metaSchema" content='<?= $article['metaSchema'] ?? ''; ?>'>
    <meta name="edit_metaCanonical"
        content="<?= !empty($article['meta_canonical']) ? $article['meta_canonical'] : current_url(); ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url(); ?>assets/img/favicon.ico">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Open Graph tags -->
    <meta property="og:title" content="<?= $article['title'] ?>">
    <meta property="og:site_name" content="iKris Pharma Network">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:description" content="<?= strip_tags(word_limiter($article['description'], 30)) ?>">
    <meta property="og:image"
        content="<?= !empty($article['image']) ? base_url('assets/images/news/' . $article['image']) : '' ?>">

    <!-- Google Tag Manager -->
    <script>
        (function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-M485LTB');
    </script>
</head>

<body class="bg-gray-50">
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M485LTB" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
    </noscript>

    <?php $this->load->view('layouts/includes/header'); ?>

    <!-- Breadcrumb Navigation -->
    <nav
        class="breadcrumb-nav bg-gradient-to-r from-gray-50 to-gray-100 py-4 px-4 border-b border-gray-200 mt-16 lg:mt-20">
        <div class="max-w-7xl mx-auto">
            <ol class="flex flex-wrap items-center gap-2 text-sm">
                <li>
                    <a href="<?= base_url(); ?>"
                        class="flex items-center gap-1 text-blue-600 hover:text-blue-800 transition">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="flex items-center gap-2">
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    <a href="<?= base_url('news-and-updates'); ?>"
                        class="text-blue-600 hover:text-blue-800 transition hover:underline">
                        News & Updates
                    </a>
                </li>
                <li class="flex items-center gap-2">
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    <span class="text-gray-900 font-semibold">
                        <?= htmlspecialchars($article['title']) ?>
                    </span>
                </li>
            </ol>
        </div>
    </nav>

    <!-- Hero Section -->
    <section
        class="relative bg-gradient-to-br from-purple-600 via-purple-700 to-purple-800 py-16 md:py-24 px-4 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0"
                style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
            </div>
        </div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-center">
                <!-- Left: Text Content -->
                <div class="space-y-6 text-white">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full">
                        <i class="fas fa-newspaper"></i>
                        <span class="text-sm font-semibold uppercase tracking-wide">
                            <?= htmlspecialchars($article['category_name'] ?? 'News') ?>
                        </span>
                    </div>

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight drop-shadow-lg">
                        <?= htmlspecialchars($article['title']) ?>
                    </h1>

                    <?php if (!empty($article['metaTitle'])): ?>
                        <p class="text-lg md:text-xl leading-relaxed opacity-95">
                            <?= htmlspecialchars($article['metaTitle']) ?>
                        </p>
                    <?php endif; ?>

                    <!-- Meta Information -->
                    <div class="flex flex-wrap gap-4 pt-4 text-white/90">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-user-edit"></i>
                            <span class="font-medium">
                                <?= htmlspecialchars($article['author_name'] ?? 'Admin') ?>
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar-alt"></i>
                            <span>
                                <?= isset($article['created_at']) ? date('F d, Y', strtotime($article['created_at'])) : '' ?>
                            </span>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="pt-4">
                        <button onclick="shareNews()"
                            class="inline-flex items-center gap-2 px-8 py-4 bg-white text-purple-700 rounded-lg hover:bg-gray-100 font-semibold text-lg transition shadow-xl hover:shadow-2xl transform hover:-translate-y-0.5">
                            <i class="fas fa-share-alt"></i>
                            Share Article
                        </button>
                    </div>
                </div>

                <!-- Right: Image -->
                <div class="relative">
                    <div class="absolute inset-0 bg-purple-400 rounded-2xl transform rotate-3 opacity-20"></div>
                    <div
                        class="relative h-64 md:h-96 rounded-2xl overflow-hidden shadow-2xl transform hover:scale-105 transition-transform duration-300">
                        <?php if (!empty($article['image'])): ?>
                            <img src="<?= base_url('assets/images/news/' . $article['image']) ?>"
                                alt="<?= htmlspecialchars($article['title']) ?>"
                                class="absolute inset-0 w-full h-full object-cover">
                        <?php else: ?>
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center">
                                <i class="fas fa-newspaper text-8xl text-white opacity-50"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-6 md:py-14 px-4 bg-gray-50">
        <div class="max-w-8xl mx-auto">
            <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12 lg:p-16">
                <div class="cms-content prose prose-lg max-w-none">
                    <?= $article['description'] ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Articles Section -->
    <?php if (!empty($related_articles)): ?>
        <section class="py-16 md:py-24 px-4 bg-white">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Related Articles</h2>
                    <p class="text-lg text-gray-600">Explore more news and updates</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($related_articles as $rel): ?>
                        <a href="<?= base_url(strtolower(str_replace(' ', '-', $rel->category_name)) . '/' . $rel->slug); ?>"
                            class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden group block">
                            <div class="h-48 bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center">
                                <i class="fas fa-newspaper text-6xl text-white opacity-50"></i>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-purple-600 transition">
                                    <?= htmlspecialchars($rel->name); ?>
                                </h3>
                                <div
                                    class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-800 font-semibold group-hover:gap-3 transition-all">
                                    Read Article
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php $this->load->view('layouts/includes/footer'); ?>

    <style>
        /* Enhanced CMS Content Styling - Same as CMS Pages */
        .cms-content {
            color: #374151;
            line-height: 1.8;
        }

        .cms-content h1,
        .cms-content h2,
        .cms-content h3,
        .cms-content h4,
        .cms-content h5,
        .cms-content h6 {
            font-weight: 700;
            margin-top: 2.5rem;
            margin-bottom: 1.25rem;
            color: #111827;
            scroll-margin-top: 100px;
        }

        .cms-content h1 {
            font-size: 2.5rem;
            line-height: 1.2;
            border-bottom: 3px solid #9333ea;
            padding-bottom: 0.75rem;
        }

        .cms-content h2 {
            font-size: 2rem;
            line-height: 1.3;
        }

        .cms-content h3 {
            font-size: 1.75rem;
            line-height: 1.4;
        }

        .cms-content h4 {
            font-size: 1.5rem;
        }

        .cms-content h5 {
            font-size: 1.25rem;
        }

        .cms-content p {
            margin-bottom: 1.5rem;
        }

        .cms-content ul,
        .cms-content ol {
            margin-left: 2rem;
            margin-bottom: 1.5rem;
            padding-left: 0.5rem;
        }

        .cms-content ul {
            list-style-type: disc;
        }

        .cms-content ol {
            list-style-type: decimal;
        }

        .cms-content li {
            margin-bottom: 0.75rem;
            padding-left: 0.5rem;
        }

        .cms-content li::marker {
            color: #9333ea;
            font-weight: 600;
        }

        .cms-content img {
            max-width: 100%;
            height: auto;
            border-radius: 1rem;
            margin: 2rem 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .cms-content a {
            color: #7c3aed;
            text-decoration: underline;
            transition: color 0.2s;
        }

        .cms-content a:hover {
            color: #6d28d9;
        }

        .cms-content blockquote {
            border-left: 4px solid #9333ea;
            padding-left: 1.5rem;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            font-style: italic;
            color: #4b5563;
            margin: 2rem 0;
            background: #f9fafb;
            border-radius: 0 0.5rem 0.5rem 0;
        }

        .cms-content code {
            background: #f3f4f6;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-family: 'Courier New', monospace;
            font-size: 0.875rem;
            color: #dc2626;
        }

        .cms-content pre {
            background: #1f2937;
            color: #f9fafb;
            padding: 1.5rem;
            border-radius: 0.75rem;
            overflow-x: auto;
            margin: 2rem 0;
        }

        .cms-content pre code {
            background: transparent;
            color: inherit;
            padding: 0;
        }

        .cms-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 2rem 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .cms-content th {
            background: #9333ea;
            color: white;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
        }

        .cms-content td {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .cms-content tr:hover td {
            background: #f9fafb;
        }

        .cms-content strong {
            font-weight: 700;
            color: #111827;
        }

        .cms-content em {
            font-style: italic;
        }

        .cms-content hr {
            border: none;
            height: 2px;
            background: linear-gradient(to right, transparent, #e5e7eb, transparent);
            margin: 3rem 0;
        }

        /* Breadcrumb hover effect */
        .breadcrumb-nav a:hover {
            text-decoration: underline;
        }
    </style>

    <script>
        // News data
        const newsData = {
            title: "<?= addslashes($article['title']) ?>",
            category: "<?= addslashes($article['category_name'] ?? 'News') ?>",
            author: "<?= addslashes($article['author_name'] ?? 'Admin') ?>",
            date: "<?= isset($article['created_at']) ? date('F d, Y', strtotime($article['created_at'])) : '' ?>",
            url: "<?= current_url() ?>"
        };

        // Share News Function
        function shareNews() {
            const shareText = `${newsData.title}

Category: ${newsData.category}
Author: ${newsData.author}
Published: ${newsData.date}

Read Full Article: ${newsData.url}`;

            if (navigator.share) {
                navigator.share({
                    text: shareText
                })
                    .then(() => {
                        showToast('News article shared successfully!', 'success');
                    })
                    .catch((err) => {
                        if (err && err.name !== 'AbortError') {
                            fallbackCopy(shareText);
                        }
                    });
            } else {
                fallbackCopy(shareText);
            }
        }

        // Fallback copy function
        function fallbackCopy(text) {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text)
                    .then(() => {
                        showToast('News article copied to clipboard!', 'success');
                    })
                    .catch((err) => {
                        console.error('Clipboard failed:', err);
                        textareaCopy(text);
                    });
            } else {
                textareaCopy(text);
            }
        }

        // Legacy textarea copy
        function textareaCopy(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.select();

            try {
                document.execCommand('copy');
                showToast('News article copied to clipboard!', 'success');
            } catch (err) {
                console.error('Copy failed:', err);
                showToast('Failed to copy. Please try manually.', 'error');
            }

            document.body.removeChild(textarea);
        }

        // Toast notification
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-600' : 'bg-red-600';
            toast.className =
                `fixed bottom-4 right-4 z-[60] px-6 py-4 rounded-lg shadow-2xl ${bgColor} text-white font-semibold flex items-center gap-3 animate-slideIn`;

            const icon = type === 'success' ?
                `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>` :
                `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>`;

            toast.innerHTML = `${icon}<span>${message}</span>`;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('animate-slideOut');
                setTimeout(() => document.body.removeChild(toast), 300);
            }, 3000);
        }

        // Add CSS animations
        document.addEventListener('DOMContentLoaded', function () {
            const style = document.createElement('style');
            style.textContent = `
                @keyframes slideIn {
                    from {
                        opacity: 0;
                        transform: translateX(100%);
                    }
                    to {
                        opacity: 1;
                        transform: translateX(0);
                    }
                }
                
                @keyframes slideOut {
                    from {
                        opacity: 1;
                        transform: translateX(0);
                    }
                    to {
                        opacity: 0;
                        transform: translateX(100%);
                    }
                }
                
                .animate-slideIn {
                    animation: slideIn 0.3s ease-out;
                }
                
                .animate-slideOut {
                    animation: slideOut 0.3s ease-out;
                }
            `;
            document.head.appendChild(style);
        });
    </script>
</body>

</html>