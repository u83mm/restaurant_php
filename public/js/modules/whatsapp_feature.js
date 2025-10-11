class WhatsAppReservation {
    constructor() {
        this.phoneNumber = '+34660176387'; // Replace with restaurant's WhatsApp number
        this.businessName = 'Your Restaurant Name'; // Replace with actual name
        this.init();
    }

    init() {
        this.setupButton();
        this.loadCustomerData();
    }

    setupButton() {
        const button = document.getElementById('whatsappReservationBtn');
        if (button) {
            button.addEventListener('click', () => this.handleReservation());
        }
    }

    loadCustomerData() {
        // Try to get customer data from localStorage or session
        this.customerName = localStorage.getItem('customerName') || '';
        this.customerPhone = localStorage.getItem('customerPhone') || '';
    }

    getCurrentDateTime() {
        const now = new Date();
        return now.toLocaleString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    generateReservationMessage() {
        const dateTime = this.getCurrentDateTime();
        const baseMessage = `Hello ${this.businessName}! I'd like to make a reservation.`;
        
        let message = baseMessage;
        
        if (this.customerName) {
            message += ` Name: ${this.customerName}`;
        }
        if (this.customerPhone) {
            message += ` Phone: ${this.customerPhone}`;
        }
        
        message += ` Date/Time: ${dateTime}`;
        
        return encodeURIComponent(message);
    }

    handleReservation() {
        // Optional: Show a quick form to collect reservation details
        this.showReservationModal();
    }

    showReservationModal() {
        // Create a simple modal for reservation details
        const modal = document.createElement('div');
        modal.className = 'reservation-modal';
        modal.innerHTML = `
            <div class="modal-content">
                <h3>Make a Reservation</h3>
                <form id="reservationForm">
                    <div class="form-group">
                        <label for="reservationName">Your Name:</label>
                        <input type="text" id="reservationName" value="${this.customerName}" required>
                    </div>
                    <div class="form-group">
                        <label for="reservationPhone">Phone Number:</label>
                        <input type="tel" id="reservationPhone" value="${this.customerPhone}" required>
                    </div>
                    <div class="form-group">
                        <label for="reservationDate">Preferred Date & Time:</label>
                        <input type="datetime-local" id="reservationDate" required>
                    </div>
                    <div class="form-group">
                        <label for="reservationGuests">Number of Guests:</label>
                        <input type="number" id="reservationGuests" min="1" max="20" value="2" required>
                    </div>
                    <div class="form-group">
                        <label for="reservationNotes">Special Requests:</label>
                        <textarea id="reservationNotes" placeholder="Any special requirements..."></textarea>
                    </div>
                    <div class="modal-buttons">
                        <button type="button" class="cancel-btn">Cancel</button>
                        <button type="submit" class="submit-btn">Open WhatsApp</button>
                    </div>
                </form>
            </div>
        `;

        // Add modal styles
        this.addModalStyles();
        document.body.appendChild(modal);

        // Handle form submission
        document.getElementById('reservationForm').addEventListener('submit', (e) => {
            e.preventDefault();
            this.processReservationForm();
        });

        // Handle cancel
        modal.querySelector('.cancel-btn').addEventListener('click', () => {
            document.body.removeChild(modal);
        });

        // Close modal when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                document.body.removeChild(modal);
            }
        });
    }

    addModalStyles() {
        const styles = `
            .reservation-modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 10000;
            }
            .modal-content {
                background: white;
                padding: 30px;
                border-radius: 10px;
                width: 90%;
                max-width: 500px;
                max-height: 90vh;
                overflow-y: auto;
            }
            .modal-content h3 {
                margin-bottom: 20px;
                color: #333;
            }
            .form-group {
                margin-bottom: 15px;
            }
            .form-group label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
                color: #555;
            }
            .form-group input,
            .form-group textarea {
                width: 100%;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 5px;
                font-size: 14px;
                box-sizing: border-box;
            }
            .form-group textarea {
                height: 80px;
                resize: vertical;
            }
            .modal-buttons {
                display: flex;
                gap: 10px;
                justify-content: flex-end;
                margin-top: 20px;
            }
            .cancel-btn, .submit-btn {
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 14px;
            }
            .cancel-btn {
                background: #f0f0f0;
                color: #333;
            }
            .submit-btn {
                background: #25D366;
                color: white;
            }
        `;

        if (!document.getElementById('modal-styles')) {
            const styleSheet = document.createElement('style');
            styleSheet.id = 'modal-styles';
            styleSheet.textContent = styles;
            document.head.appendChild(styleSheet);
        }
    }

    processReservationForm() {
        const form = document.getElementById('reservationForm');
        const formData = new FormData(form);
        
        // Save customer data for future use
        const name = document.getElementById('reservationName').value;
        const phone = document.getElementById('reservationPhone').value;
        const date = document.getElementById('reservationDate').value;
        const guests = document.getElementById('reservationGuests').value;
        const notes = document.getElementById('reservationNotes').value;

        // Save to localStorage
        localStorage.setItem('customerName', name);
        localStorage.setItem('customerPhone', phone);

        // Generate detailed message
        const reservationDate = new Date(date).toLocaleString();
        let message = `Hello ${this.businessName}! I'd like to make a reservation.\n\n`;
        message += `Name: ${name}\n`;
        message += `Phone: ${phone}\n`;
        message += `Date & Time: ${reservationDate}\n`;
        message += `Number of Guests: ${guests}\n`;
        
        if (notes.trim()) {
            message += `Special Requests: ${notes}`;
        }

        // Open WhatsApp
        this.openWhatsApp(message);
        
        // Close modal
        const modal = document.querySelector('.reservation-modal');
        if (modal) {
            document.body.removeChild(modal);
        }
    }

    openWhatsApp(message) {
        const encodedMessage = encodeURIComponent(message);
        const whatsappUrl = `https://wa.me/${this.phoneNumber}?text=${encodedMessage}`;
        
        // Open in new tab
        window.open(whatsappUrl, '_blank');
        
        // Track the conversion (you can integrate with analytics here)
        this.trackReservationAttempt();
    }

    trackReservationAttempt() {
        // You can integrate with Google Analytics or your custom analytics here
        console.log('Reservation attempt tracked');
        
        // Example: Send to your backend
        fetch('/api/track-reservation', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'whatsapp_reservation_click',
                timestamp: new Date().toISOString()
            })
        }).catch(error => console.error('Tracking error:', error));
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new WhatsAppReservation();
});