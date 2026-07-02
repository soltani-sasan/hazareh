/* ====================== FOOTER ====================== */
.main-footer {
    background: #0a2a5e;
    color: #ddd;
}

.footer-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 40px;
    padding: 50px 0;
}

.footer-col h4 {
    color: #f8b400;
    margin-bottom: 20px;
    border-bottom: 2px solid #f8b400;
    padding-bottom: 8px;
}

.footer-col ul {
    list-style: none;
    padding: 0;
}

.footer-col ul li a {
    color: #ddd;
    text-decoration: none;
    line-height: 2.1;
    transition: 0.3s;
}

.footer-col ul li a:hover {
    color: #f8b400;
    padding-right: 8px;
}

.footer-bottom {
    background: #051d42;
    padding: 18px 0;
    text-align: center;
    font-size: 14px;
    color: #aaa;
}

/* Responsive */
@media (max-width: 992px) {
    .nav-wrapper {
        justify-content: center;
    }
    .main-menu ul {
        justify-content: flex-start;
    }
}

@media (max-width: 768px) {
    .hero-banner {
        height: 380px;
    }
    .main-menu a {
        padding: 12px 14px;
        font-size: 14px;
    }
}