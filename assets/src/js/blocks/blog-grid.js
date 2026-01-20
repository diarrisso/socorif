/**
 * Blog Grid Block JavaScript
 *
 * Handles AJAX filtering, pagination, and dynamic content loading
 */

(function() {
    'use strict';

    /**
     * Blog Grid Class
     */
    class BlogGridBlock {
        constructor(element, blockId) {
            this.element = element;
            this.blockId = blockId;
            this.config = window.blogGridConfig?.[blockId] || {};
            this.alpineData = null;

            this.init();
        }

        /**
         * Initialize the block
         */
        init() {
            // Get Alpine data from element
            if (window.Alpine) {
                this.alpineData = this.element.__x?.$data;
            }

            // Setup event listeners
            this.setupEventListeners();

            // Setup infinite scroll if enabled
            if (this.config.paginationType === 'infinite') {
                this.setupInfiniteScroll();
            }
        }

        /**
         * Setup event listeners
         */
        setupEventListeners() {
            // Filter event
            this.element.addEventListener('blog-grid-filter', () => {
                this.filterPosts();
            });

            // Load more event
            this.element.addEventListener('blog-grid-loadmore', () => {
                this.loadMore();
            });

            // Page change event
            this.element.addEventListener('blog-grid-page', (event) => {
                this.changePage(event.detail.page);
            });
        }

        /**
         * Setup infinite scroll
         */
        setupInfiniteScroll() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !this.alpineData.loading) {
                        if (this.alpineData.currentPage < this.alpineData.maxPages) {
                            this.loadMore();
                        }
                    }
                });
            }, {
                rootMargin: '200px'
            });

            // Observe a sentinel element at the bottom
            const sentinel = document.createElement('div');
            sentinel.className = 'blog-grid-sentinel';
            this.element.querySelector('.mx-auto.max-w-7xl').appendChild(sentinel);
            observer.observe(sentinel);
        }

        /**
         * Filter posts
         */
        async filterPosts() {
            if (!this.alpineData) return;

            this.alpineData.loading = true;
            this.alpineData.currentPage = 1;

            try {
                const response = await this.fetchPosts();

                if (response.success) {
                    this.alpineData.posts = response.posts;
                    this.alpineData.maxPages = response.pagination.total_pages;
                    this.alpineData.currentPage = response.pagination.current_page;

                    // Scroll to results
                    this.element.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            } catch (error) {
                console.error('Error filtering posts:', error);
                this.showError('Fehler beim Filtern der Beiträge. Bitte versuchen Sie es erneut.');
            } finally {
                this.alpineData.loading = false;
            }
        }

        /**
         * Load more posts
         */
        async loadMore() {
            if (!this.alpineData) return;
            if (this.alpineData.currentPage >= this.alpineData.maxPages) return;

            this.alpineData.loading = true;
            const nextPage = this.alpineData.currentPage + 1;

            try {
                const response = await this.fetchPosts(nextPage);

                if (response.success) {
                    // Append new posts
                    this.alpineData.posts = [...this.alpineData.posts, ...response.posts];
                    this.alpineData.currentPage = response.pagination.current_page;
                    this.alpineData.maxPages = response.pagination.total_pages;
                }
            } catch (error) {
                console.error('Error loading more posts:', error);
                this.showError('Fehler beim Laden weiterer Beiträge. Bitte versuchen Sie es erneut.');
            } finally {
                this.alpineData.loading = false;
            }
        }

        /**
         * Change page (standard pagination)
         */
        async changePage(page) {
            if (!this.alpineData) return;
            if (page < 1 || page > this.alpineData.maxPages) return;
            if (page === this.alpineData.currentPage) return;

            this.alpineData.loading = true;

            try {
                const response = await this.fetchPosts(page);

                if (response.success) {
                    this.alpineData.posts = response.posts;
                    this.alpineData.currentPage = response.pagination.current_page;
                    this.alpineData.maxPages = response.pagination.total_pages;

                    // Scroll to top of results
                    this.element.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            } catch (error) {
                console.error('Error changing page:', error);
                this.showError('Fehler beim Laden der Seite. Bitte versuchen Sie es erneut.');
            } finally {
                this.alpineData.loading = false;
            }
        }

        /**
         * Fetch posts from AJAX endpoint
         */
        async fetchPosts(page = 1) {
            const formData = new FormData();
            formData.append('action', 'beka_blog_grid_load');
            formData.append('nonce', this.config.nonce);
            formData.append('paged', page);
            formData.append('posts_per_page', this.config.postsPerPage);
            formData.append('orderby', this.alpineData.sortBy || this.config.orderby);

            // Categories
            const categories = this.alpineData.selectedCategories;
            if (categories && categories.length > 0) {
                if (Array.isArray(categories)) {
                    categories.forEach(cat => formData.append('categories[]', cat));
                } else {
                    formData.append('categories[]', categories);
                }
            }

            // Tags
            const tags = this.alpineData.selectedTags;
            if (tags && tags.length > 0) {
                if (Array.isArray(tags)) {
                    tags.forEach(tag => formData.append('tags[]', tag));
                } else {
                    formData.append('tags[]', tags);
                }
            }

            // Search
            if (this.alpineData.searchQuery) {
                formData.append('search', this.alpineData.searchQuery);
            }

            const response = await fetch(this.config.ajaxUrl, {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            return await response.json();
        }

        /**
         * Show error message
         */
        showError(message) {
            // Create error notification
            const notification = document.createElement('div');
            notification.className = 'blog-grid-error fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 max-w-md';
            notification.textContent = message;

            document.body.appendChild(notification);

            // Auto remove after 5 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transition = 'opacity 0.3s';
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }
    }

    /**
     * Global initialization function
     */
    window.BlogGrid = {
        instances: {},

        init: function(element, blockId) {
            if (!this.instances[blockId]) {
                this.instances[blockId] = new BlogGridBlock(element, blockId);
            }
            return this.instances[blockId];
        }
    };

    /**
     * Auto-initialize on page load
     */
    document.addEventListener('DOMContentLoaded', function() {
        const blogGridBlocks = document.querySelectorAll('.blog-grid-block[x-data]');

        blogGridBlocks.forEach(block => {
            const blockId = block.id;
            if (blockId && window.blogGridConfig?.[blockId]) {
                // Wait for Alpine to initialize
                setTimeout(() => {
                    window.BlogGrid.init(block, blockId);
                }, 100);
            }
        });
    });

})();
