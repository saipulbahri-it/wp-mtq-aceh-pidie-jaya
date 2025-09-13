/**
 * MTQ Countdown JavaScript - Enhanced Version
 * Supports dynamic configuration, state management, and event completion
 * Created by @saipulbahri-it
 */
(function() {
    'use strict';

    // Countdown configuration and state management
    const MTQCountdown = {
        // Default configuration (will be overridden by WordPress options)
        config: {
            targetDate: '2025-11-01T07:00:00',
            eventTitle: 'MTQ Aceh XXXVII Pidie Jaya 2025',
            eventLocation: 'Kabupaten Pidie Jaya, Aceh',
            status: 'active' // active, paused, completed, hidden
        },
        
        // Runtime state
        state: {
            isRunning: false,
            isPaused: false,
            isCompleted: false,
            interval: null,
            lastUpdate: null,
            animationFrame: null
        },
        
        // DOM elements cache
        elements: {},
        
        // Initialize countdown
        init() {
            this.loadConfiguration();
            this.cacheElements();
            this.setupEventListeners();
            this.start();
        },
        
        // Load configuration from WordPress
        loadConfiguration() {
            // Check if WordPress provides countdown configuration
            if (typeof window.mtqCountdownConfig !== 'undefined') {
                Object.assign(this.config, window.mtqCountdownConfig);
            }
            
            // Parse target date
            this.config.targetTimestamp = new Date(this.config.targetDate).getTime();
            
            // Validate configuration
            if (isNaN(this.config.targetTimestamp)) {
                console.warn('MTQ Countdown: Invalid target date, using default');
                this.config.targetTimestamp = new Date('2025-11-01T07:00:00').getTime();
            }
        },
        
        // Cache DOM elements
        cacheElements() {
            this.elements = {
                container: document.querySelector('.countdown-container'),
                days: document.getElementById('days'),
                hours: document.getElementById('hours'),
                minutes: document.getElementById('minutes'),
                seconds: document.getElementById('seconds'),
                eventTitle: document.querySelector('.countdown-title'),
                eventLocation: document.querySelector('.countdown-location'),
                completedMessage: document.querySelector('.countdown-completed'),
                pausedMessage: document.querySelector('.countdown-paused')
            };
        },
        
        // Setup event listeners
        setupEventListeners() {
            // Listen for configuration updates
            document.addEventListener('mtq-countdown-update', (e) => {
                this.updateConfiguration(e.detail);
            });
            
            // Listen for visibility changes
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    this.pause();
                } else {
                    this.resume();
                }
            });
            
            // Window focus/blur optimization
            window.addEventListener('blur', () => this.pause());
            window.addEventListener('focus', () => this.resume());
        },
        
        // Start countdown
        start() {
            if (this.config.status === 'hidden') {
                this.hide();
                return;
            }
            
            if (this.config.status === 'completed') {
                this.showCompleted();
                return;
            }
            
            if (this.config.status === 'paused') {
                this.showPaused();
                return;
            }
            
            this.show();
            this.updateDisplay();
            
            if (!this.state.isRunning) {
                this.state.isRunning = true;
                this.state.interval = setInterval(() => this.updateDisplay(), 1000);
            }
        },
        
        // Stop countdown
        stop() {
            this.state.isRunning = false;
            if (this.state.interval) {
                clearInterval(this.state.interval);
                this.state.interval = null;
            }
            if (this.state.animationFrame) {
                cancelAnimationFrame(this.state.animationFrame);
                this.state.animationFrame = null;
            }
        },
        
        // Pause countdown
        pause() {
            this.state.isPaused = true;
        },
        
        // Resume countdown
        resume() {
            this.state.isPaused = false;
        },
        
        // Update countdown display
        updateDisplay() {
            if (this.state.isPaused || !this.state.isRunning) return;
            
            const now = new Date().getTime();
            const distance = this.config.targetTimestamp - now;
            
            // Check if event has started/completed
            if (distance <= 0) {
                this.handleEventCompletion();
                return;
            }
            
            // Calculate time components
            const timeLeft = this.calculateTimeLeft(distance);
            
            // Update DOM with smooth animations
            this.updateTimeDisplay(timeLeft);
            
            // Update metadata
            this.updateMetadata(timeLeft);
            
            this.state.lastUpdate = now;
        },
        
        // Calculate time left
        calculateTimeLeft(distance) {
            return {
                days: Math.floor(distance / (1000 * 60 * 60 * 24)),
                hours: Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)),
                minutes: Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)),
                seconds: Math.floor((distance % (1000 * 60)) / 1000),
                total: distance
            };
        },
        
        // Update time display with animations
        updateTimeDisplay(timeLeft) {
            const elements = this.elements;
            
            if (elements.days) this.animateValueChange(elements.days, timeLeft.days, 3);
            if (elements.hours) this.animateValueChange(elements.hours, timeLeft.hours, 2);
            if (elements.minutes) this.animateValueChange(elements.minutes, timeLeft.minutes, 2);
            if (elements.seconds) this.animateValueChange(elements.seconds, timeLeft.seconds, 2);
        },
        
        // Animate value changes
        animateValueChange(element, newValue, digits = 2) {
            const currentValue = parseInt(element.textContent) || 0;
            const formattedValue = String(newValue).padStart(digits, '0');
            
            if (currentValue !== newValue) {
                element.style.transform = 'scale(0.9)';
                element.style.transition = 'transform 0.15s ease';
                
                setTimeout(() => {
                    element.textContent = formattedValue;
                    element.style.transform = 'scale(1)';
                }, 75);
            }
        },
        
        // Update metadata (title, location, progress)
        updateMetadata(timeLeft) {
            // Update title if element exists
            if (this.elements.eventTitle) {
                this.elements.eventTitle.textContent = this.config.eventTitle;
            }
            
            // Update location if element exists
            if (this.elements.eventLocation) {
                this.elements.eventLocation.textContent = this.config.eventLocation;
            }
            
            // Update page title with countdown
            if (timeLeft.days > 0) {
                document.title = `${timeLeft.days}d ${timeLeft.hours}h ${timeLeft.minutes}m - ${this.config.eventTitle}`;
            } else if (timeLeft.hours > 0) {
                document.title = `${timeLeft.hours}h ${timeLeft.minutes}m ${timeLeft.seconds}s - ${this.config.eventTitle}`;
            } else {
                document.title = `${timeLeft.minutes}m ${timeLeft.seconds}s - ${this.config.eventTitle}`;
            }
        },
        
        // Handle event completion
        handleEventCompletion() {
            this.stop();
            this.state.isCompleted = true;
            
            // Trigger completion event
            const completionEvent = new CustomEvent('mtq-countdown-completed', {
                detail: {
                    eventTitle: this.config.eventTitle,
                    eventLocation: this.config.eventLocation,
                    targetDate: this.config.targetDate
                }
            });
            document.dispatchEvent(completionEvent);
            
            // Show completion state
            this.showCompleted();
            
            // Analytics tracking
            if (typeof gtag !== 'undefined') {
                gtag('event', 'countdown_completed', {
                    event_category: 'MTQ Event',
                    event_label: this.config.eventTitle
                });
            }
        },
        
        // Show completed state
        showCompleted() {
            if (this.elements.container) {
                this.elements.container.classList.add('countdown-completed');
            }
            
            // Reset display to zeros
            if (this.elements.days) this.elements.days.textContent = '000';
            if (this.elements.hours) this.elements.hours.textContent = '00';
            if (this.elements.minutes) this.elements.minutes.textContent = '00';
            if (this.elements.seconds) this.elements.seconds.textContent = '00';
            
            // Show completion message
            if (this.elements.completedMessage) {
                this.elements.completedMessage.style.display = 'block';
            }
            
            // Update page title
            document.title = `🎉 ${this.config.eventTitle} - Acara Telah Dimulai!`;
        },
        
        // Show paused state
        showPaused() {
            if (this.elements.container) {
                this.elements.container.classList.add('countdown-paused');
            }
            
            if (this.elements.pausedMessage) {
                this.elements.pausedMessage.style.display = 'block';
            }
        },
        
        // Show countdown
        show() {
            if (this.elements.container) {
                this.elements.container.style.display = 'block';
                this.elements.container.classList.remove('countdown-completed', 'countdown-paused');
            }
            
            // Hide status messages
            if (this.elements.completedMessage) {
                this.elements.completedMessage.style.display = 'none';
            }
            if (this.elements.pausedMessage) {
                this.elements.pausedMessage.style.display = 'none';
            }
        },
        
        // Hide countdown
        hide() {
            if (this.elements.container) {
                this.elements.container.style.display = 'none';
            }
        },
        
        // Update configuration dynamically
        updateConfiguration(newConfig) {
            Object.assign(this.config, newConfig);
            
            // Recalculate target timestamp if date changed
            if (newConfig.targetDate) {
                this.config.targetTimestamp = new Date(this.config.targetDate).getTime();
            }
            
            // Restart countdown with new config
            this.stop();
            this.start();
        },
        
        // Get current state (for debugging)
        getState() {
            return {
                config: { ...this.config },
                state: { ...this.state },
                timeLeft: this.calculateTimeLeft(this.config.targetTimestamp - new Date().getTime())
            };
        }
    };

    // Initialize countdown when DOM is ready
    function initCountdown() {
        // Check if countdown elements exist
        const hasCountdownElements = 
            document.getElementById('days') || 
            document.getElementById('hours') || 
            document.getElementById('minutes') || 
            document.getElementById('seconds') ||
            document.querySelector('.countdown-container');
            
        if (hasCountdownElements) {
            MTQCountdown.init();
            
            // Make countdown globally accessible for debugging
            window.MTQCountdown = MTQCountdown;
        }
    }
    
    // Start countdown when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCountdown);
    } else {
        initCountdown();
    }
    
})();