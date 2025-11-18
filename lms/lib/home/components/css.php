<style>
.ceremony-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 40px;
    max-width: 100%;
    width: 100%;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    overflow: hidden;
    margin: 20px 0 20px 0;
}

.ceremony-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4);
    background-size: 300% 300%;
    animation: gradient 3s ease infinite;
}

@keyframes gradient {
    0% {
        background-position: 0% 50%;
    }

    50% {
        background-position: 100% 50%;
    }

    100% {
        background-position: 0% 50%;
    }
}

.header {
    text-align: center;
    margin-bottom: 30px;
}

.ceremony-title {
    font-size: 1.4rem;
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.ceremony-icon {
    width: 24px;
    height: 24px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 14px;
}

.ceremony-number {
    font-size: 3rem;
    font-weight: 700;
    color: #34495e;
    margin-bottom: 10px;
    letter-spacing: -1px;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #ff6b6b;
    color: white;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 25px;
}

.warning-icon {
    width: 16px;
    height: 16px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

.payment-details {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 25px;
    margin-top: 20px;
    border-left: 4px solid #ff6b6b;
}

.payment-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.balance-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #dee2e6;
}


.balance-label {
    color: #6c757d;
    font-weight: 500;
}

.balance-amount {
    font-weight: 600;
    color: #dc3545;
}

.total-amount {
    color: #dc3545 !important;
    font-size: 1.2rem !important;
}

.action-button {
    width: 100%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    margin-top: 25px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.action-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.registration-info {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 25px;
    margin-top: 20px;
    border-left: 4px solid #4ecdc4;
}

.info-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.info-item {
    background: white;
    padding: 18px;
    border-radius: 12px;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.info-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(78, 205, 196, 0.15);
    border-color: #4ecdc4;
}

.info-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #4ecdc4, #44a08d);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.info-item:hover::before {
    transform: scaleX(1);
}

.info-label {
    font-size: 0.85rem;
    color: #6c757d;
    font-weight: 500;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    word-break: break-word;
}

.help-text {
    text-align: center;
    color: #6c757d;
    font-size: 0.9rem;
    margin-top: 20px;
    line-height: 1.5;
}

/* Mobile First Responsive Design */
@media (max-width: 768px) {
    body {
        padding: 15px;
    }

    .ceremony-card {
        padding: 30px 25px;
        margin: 0;
        max-width: 100%;
        border-radius: 15px;
    }

    .ceremony-title {
        font-size: 1.2rem;
        flex-direction: column;
        gap: 8px;
    }

    .ceremony-number {
        font-size: 2.5rem;
        margin-bottom: 15px;
    }

    .payment-details {
        padding: 20px 15px;
        margin-top: 25px;
    }

    .payment-title {
        font-size: 1rem;
        margin-bottom: 15px;
    }

    .balance-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
        padding: 15px 0;
    }

    .balance-amount {
        align-self: flex-end;
        font-size: 1.1rem;
    }

    .action-button {
        padding: 18px 25px;
        font-size: 0.95rem;
        margin-top: 20px;
    }

    .help-text {
        font-size: 0.85rem;
        margin-top: 15px;
    }
}

@media (max-width: 480px) {
    body {
        padding: 10px;
    }

    .ceremony-card {
        padding: 25px 20px;
        border-radius: 12px;
    }

    .ceremony-title {
        font-size: 1.1rem;
    }

    .ceremony-number {
        font-size: 2.2rem;
    }

    .status-badge {
        font-size: 0.8rem;
        padding: 6px 12px;
    }

    .payment-details {
        padding: 18px 12px;
        border-radius: 12px;
    }

    .payment-title {
        font-size: 0.95rem;
    }

    .balance-item {
        padding: 12px 0;
    }

    .balance-label {
        font-size: 0.9rem;
    }

    .balance-amount {
        font-size: 1rem;
    }

    .total-amount {
        font-size: 1.1rem !important;
    }

    .action-button {
        padding: 16px 20px;
        font-size: 0.9rem;
        border-radius: 10px;
    }
}

@media (max-width: 360px) {
    .ceremony-card {
        padding: 20px 15px;
    }

    .ceremony-number {
        font-size: 2rem;
    }

    .payment-details {
        padding: 15px 10px;
    }

    .balance-item {
        padding: 10px 0;
    }

    .action-button {
        padding: 14px 18px;
        font-size: 0.85rem;
    }

    .help-text {
        font-size: 0.8rem;
    }
}

/* Tablet Landscape */
@media (min-width: 769px) and (max-width: 1024px) {
    .ceremony-card {
        max-width: 600px;
        padding: 45px;
    }

    .ceremony-number {
        font-size: 3.5rem;
    }

    .payment-details {
        padding: 30px;
    }
}

/* Large Desktop */
@media (min-width: 1200px) {
    .ceremony-card {
        /* max-width: 550px; */
        padding: 50px;
    }

    .ceremony-number {
        font-size: 3.2rem;
    }
}

/* Landscape Mobile */
@media (max-height: 500px) and (orientation: landscape) {
    body {
        align-items: flex-start;
        padding: 20px 10px;
    }

    .ceremony-card {
        margin: 20px auto;
        max-height: 90vh;
        overflow-y: auto;
    }

    .ceremony-number {
        font-size: 2rem;
        margin-bottom: 10px;
    }

    .payment-details {
        margin-top: 15px;
    }

    .help-text {
        margin-top: 15px;
    }
}
</style>