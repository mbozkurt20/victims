<template>
    <!-- Hero Section -->
    <section class="hero-section" style="background-image: url('/images/21.jpg')">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-badge">🐄 Güvenilir Kurban Hizmeti</div>
            <h1 class="hero-title">Eyvan Kurban Hizmetleri</h1>
            <p class="hero-subtitle">Kurban satım ve kesim işlemleri için size en iyi hizmeti vermek için beraberiz.</p>
            <div class="hero-actions">
                <router-link :to="{ name: 'posts.index' }" class="btn-primary-hero">Kurbanları İncele</router-link>
                <router-link :to="{ name: 'login' }" class="btn-outline-hero">Giriş Yap</router-link>
            </div>
        </div>
        <div class="hero-scroll">↓</div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="section-header">
                <h2>Neden Bizi Tercih Etmelisiniz?</h2>
                <p>Yıllarca süren deneyimimizle en kaliteli hizmeti sunuyoruz</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🐄</div>
                    <h3>Kaliteli Hayvanlar</h3>
                    <p>Tüm kurbanlarımız veteriner kontrolünden geçmiş, sağlıklı ve standartlara uygun hayvanlardır.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">✂️</div>
                    <h3>Hijyenik Kesim</h3>
                    <p>İslami usullere uygun, hijyenik ortamda gerçekleştirilen profesyonel kesim hizmeti sunuyoruz.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🚚</div>
                    <h3>Hızlı Teslimat</h3>
                    <p>Kesim sonrası etleriniz en kısa sürede hijyenik şekilde paketlenerek teslim edilir.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💳</div>
                    <h3>Hisse Sistemi</h3>
                    <p>7 kişiye kadar hisse imkânı ile bütçenize uygun kurban hizmetinden yararlanabilirsiniz.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services-section">
        <div class="container">
            <div class="services-inner">
                <div class="services-text">
                    <span class="section-tag">Hizmetlerimiz</span>
                    <h2>Eksiksiz Kurban Hizmeti</h2>
                    <p>Kurban seçiminden kesim ve teslimatına kadar tüm süreci sizin için yönetiyoruz. Güvenilir, şeffaf ve profesyonel bir hizmet anlayışıyla yanınızdayız.</p>
                    <ul class="services-list">
                        <li>✓ Online kurban seçimi ve rezervasyon</li>
                        <li>✓ Hisseli kurban imkânı</li>
                        <li>✓ Veteriner onaylı sağlıklı hayvanlar</li>
                        <li>✓ Profesyonel kesim ekibi</li>
                        <li>✓ Paketleme ve teslimat hizmeti</li>
                    </ul>
                    <router-link :to="{ name: 'posts.index' }" class="btn-primary-hero" style="display:inline-flex; margin-top:1.5rem">
                        Kurbanları Görüntüle
                    </router-link>
                </div>
                <div class="services-image">
                    <img src="/images/21.jpg" alt="Kurban hizmetleri" />
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Kurbanınızı Hemen Seçin</h2>
                <p>Sınırlı sayıda kurban mevcuttur. Yerinizi hemen ayırtın.</p>
                <router-link :to="{ name: 'posts.index' }" class="btn-white-hero">Şimdi Başla</router-link>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-inner">
                <div class="footer-brand">
                    <span>🐄</span>
                    <strong>Eyvan Kurban Hizmetleri</strong>
                </div>
                <p class="footer-copy">© {{ new Date().getFullYear() }} Tüm hakları saklıdır.</p>
            </div>
        </div>
    </footer>
</template>

<script setup>
</script>

<style scoped>
* { box-sizing: border-box; }

/* Hero */
.hero-section {
    position: relative;
    min-height: 100vh;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}
.hero-overlay {
    position: absolute;
    inset: 0;
    background: rgba(20, 24, 36, 0.65);
}
.hero-content {
    position: relative;
    z-index: 1;
    color: #fff;
    padding: 2rem;
    max-width: 720px;
}
.hero-badge {
    display: inline-block;
    background: rgba(227, 141, 2, 0.9);
    color: #fff;
    font-size: 0.875rem;
    font-weight: 600;
    padding: 0.4rem 1rem;
    border-radius: 2rem;
    margin-bottom: 1.25rem;
    letter-spacing: 0.5px;
}
.hero-title {
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 800;
    line-height: 1.15;
    margin-bottom: 1rem;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}
.hero-subtitle {
    font-size: 1.125rem;
    opacity: 0.9;
    max-width: 560px;
    margin: 0 auto 2rem;
    line-height: 1.7;
}
.hero-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}
.btn-primary-hero {
    display: inline-flex;
    align-items: center;
    background: #e38d02;
    color: #fff;
    text-decoration: none;
    padding: 0.75rem 1.75rem;
    border-radius: 0.5rem;
    font-weight: 700;
    font-size: 0.95rem;
    transition: background 0.2s, transform 0.15s;
}
.btn-primary-hero:hover { background: #c97c00; transform: translateY(-1px); color: #fff; }
.btn-outline-hero {
    display: inline-flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.12);
    border: 2px solid rgba(255, 255, 255, 0.6);
    color: #fff;
    text-decoration: none;
    padding: 0.75rem 1.75rem;
    border-radius: 0.5rem;
    font-weight: 700;
    font-size: 0.95rem;
    transition: background 0.2s;
    backdrop-filter: blur(4px);
}
.btn-outline-hero:hover { background: rgba(255, 255, 255, 0.22); color: #fff; }
.hero-scroll {
    position: absolute;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
    color: rgba(255, 255, 255, 0.7);
    font-size: 1.5rem;
    animation: bounce 2s infinite;
}
@keyframes bounce {
    0%, 100% { transform: translateX(-50%) translateY(0); }
    50% { transform: translateX(-50%) translateY(8px); }
}

/* Features */
.features-section {
    padding: 5rem 1.5rem;
    background: #fff;
}
.container { max-width: 1100px; margin: 0 auto; padding: 0 1rem; }
.section-header { text-align: center; margin-bottom: 3rem; }
.section-header h2 { font-size: 2rem; font-weight: 800; color: #1a1f2e; margin-bottom: 0.75rem; }
.section-header p { color: #6c757d; font-size: 1rem; margin: 0; }
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
    gap: 1.5rem;
}
.feature-card {
    background: #f8f9fc;
    border-radius: 1rem;
    padding: 2rem 1.5rem;
    text-align: center;
    border: 1px solid #e9ecef;
    transition: transform 0.2s, box-shadow 0.2s;
}
.feature-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08); }
.feature-icon { font-size: 2.5rem; margin-bottom: 1rem; }
.feature-card h3 { font-size: 1.1rem; font-weight: 700; color: #1a1f2e; margin-bottom: 0.75rem; }
.feature-card p { font-size: 0.9rem; color: #6c757d; line-height: 1.6; margin: 0; }

/* Services */
.services-section {
    padding: 5rem 1.5rem;
    background: #f0f2fc;
}
.services-inner {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
}
@media (max-width: 768px) { .services-inner { grid-template-columns: 1fr; } }
.section-tag {
    display: inline-block;
    background: rgba(227, 141, 2, 0.15);
    color: #e38d02;
    font-size: 0.8rem;
    font-weight: 700;
    padding: 0.3rem 0.8rem;
    border-radius: 2rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.75rem;
}
.services-text h2 { font-size: 1.75rem; font-weight: 800; color: #1a1f2e; margin-bottom: 1rem; }
.services-text p { color: #6c757d; line-height: 1.7; margin-bottom: 1.25rem; }
.services-list { list-style: none; padding: 0; margin: 0; }
.services-list li { padding: 0.4rem 0; color: #495057; font-size: 0.95rem; font-weight: 500; }
.services-image img {
    width: 100%;
    border-radius: 1rem;
    object-fit: cover;
    height: 380px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
}

/* CTA */
.cta-section {
    background: linear-gradient(135deg, #1a1f2e, #2d3452);
    padding: 5rem 1.5rem;
    text-align: center;
}
.cta-content h2 { font-size: 2rem; font-weight: 800; color: #fff; margin-bottom: 0.75rem; }
.cta-content p { color: rgba(255, 255, 255, 0.75); margin-bottom: 2rem; font-size: 1rem; }
.btn-white-hero {
    display: inline-flex;
    background: #fff;
    color: #1a1f2e;
    text-decoration: none;
    padding: 0.8rem 2rem;
    border-radius: 0.5rem;
    font-weight: 700;
    font-size: 0.95rem;
    transition: background 0.2s, transform 0.15s;
}
.btn-white-hero:hover { background: #f0f2fc; transform: translateY(-1px); color: #1a1f2e; }

/* Footer */
.site-footer {
    background: #141824;
    padding: 1.75rem 1.5rem;
}
.footer-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    max-width: 1100px;
    margin: 0 auto;
}
.footer-brand { display: flex; align-items: center; gap: 0.5rem; color: #fff; font-size: 0.95rem; }
.footer-copy { color: rgba(255, 255, 255, 0.45); font-size: 0.8rem; margin: 0; }
</style>
