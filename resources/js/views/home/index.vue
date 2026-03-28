<template>
    <div class="landing">

        <!-- ═══ HERO ═══ -->
        <section class="hero">
            <div class="hero-bg" :style="{ backgroundImage: `url('/images/eidmubarek.jpg')` }"></div>
            <div class="hero-overlay"></div>
            <!-- İslami geometrik süsleme -->
            <div class="hero-geo hero-geo-left">
                <GeomStar :size="320" opacity="0.07" />
            </div>
            <div class="hero-geo hero-geo-right">
                <GeomStar :size="480" opacity="0.05" />
            </div>
            <div class="hero-inner">
                <div class="hero-badge-wrap">
                    <span class="hero-crescent">☽</span>
                    <span class="hero-badge-text">Kurban Bayramı Hizmetleri</span>
                </div>
                <h1 class="hero-title">
                    Eyvan Kurban<br />
                    <span class="hero-title-accent">Hizmetleri</span>
                </h1>
                <p class="hero-sub">
                    İslami usullere uygun, profesyonel kurban satım ve kesim hizmetleriyle<br class="d-none d-md-inline" />
                    Kurban Bayramı'nda yanınızdayız.
                </p>
                <div class="hero-actions">
                    <router-link :to="{ name: 'posts.index' }" class="btn-gold">
                        Kurbanları İncele
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"/>
                        </svg>
                    </router-link>
                    <router-link :to="{ name: 'login' }" class="btn-ghost-white">Giriş Yap</router-link>
                </div>
                <!-- İstatistik çubukları -->
                <div class="hero-stats">
                    <div class="hero-stat">
                        <span class="hs-num">100%</span>
                        <span class="hs-label">İslami Usul</span>
                    </div>
                    <div class="hero-stat-divider"></div>
                    <div class="hero-stat">
                        <span class="hs-num">7</span>
                        <span class="hs-label">Hissedar / Kurban</span>
                    </div>
                    <div class="hero-stat-divider"></div>
                    <div class="hero-stat">
                        <span class="hs-num">Vet.</span>
                        <span class="hs-label">Onaylı Hayvanlar</span>
                    </div>
                </div>
            </div>
            <!-- Scroll indicator -->
            <div class="hero-scroll">
                <div class="scroll-dot"></div>
            </div>
        </section>

        <!-- ═══ İLETİŞİM HERO ═══ -->
        <section class="contact-hero">
            <div class="contact-hero-bg"></div>
            <div class="contact-hero-overlay"></div>
            <div class="contact-hero-inner">
                <div class="ch-tag">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                    </svg>
                    İletişim
                </div>
                <h2 class="ch-title">Bize Ulaşın</h2>
                <p class="ch-sub">Kurban hakkında bilgi almak, hisse ayırtmak veya sorularınız için bizi arayın.</p>
                <div class="ch-contact-card">
                    <div class="ch-person">
                        <div class="ch-avatar">İA</div>
                        <div class="ch-person-info">
                            <span class="ch-name">İbrahim Avcılar</span>
                            <span class="ch-role">Kurban Sorumlusu</span>
                        </div>
                    </div>
                    <div class="ch-divider"></div>
                    <div class="ch-actions">
                        <a href="tel:05352071087" class="ch-btn ch-btn-call">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328z"/>
                            </svg>
                            0535 207 10 87
                        </a>
                        <a href="https://wa.me/905352071087" target="_blank" rel="noopener" class="ch-btn ch-btn-wp">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                            </svg>
                            WhatsApp'tan Yaz
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ═══ BİSMİLLAH BAND ═══ -->
        <div class="bismillah-band">
            <div class="band-inner">
                <span class="band-arabic">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</span>
                <span class="band-sep">✦</span>
                <span class="band-text">Kurban ibadeti, Allah'a yakınlaşmanın en güzel vesilelerinden biridir.</span>
            </div>
        </div>

        <!-- ═══ HİZMETLER ═══ -->
        <section class="services-sec">
            <div class="container">
                <div class="sec-header">
                    <span class="sec-tag">Hizmetlerimiz</span>
                    <h2 class="sec-title">Neden Bizi Seçmelisiniz?</h2>
                    <p class="sec-sub">Yıllarca süren deneyimimizle Kurban Bayramı'nda size en iyi hizmeti sunuyoruz</p>
                </div>

                <div class="services-grid">
                    <div class="srv-card">
                        <div class="srv-icon-wrap srv-green">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                            </svg>
                        </div>
                        <h3>Veteriner Onaylı</h3>
                        <p>Tüm kurbanlarımız veteriner hekim kontrolünden geçmiş, sağlıklı ve standartlara uygun hayvanlardır.</p>
                    </div>
                    <div class="srv-card">
                        <div class="srv-icon-wrap srv-gold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5z"/>
                            </svg>
                        </div>
                        <h3>İslami Usul</h3>
                        <p>Kesimler İslami kurallara uygun, dini gereklilikler eksiksiz yerine getirilerek gerçekleştirilmektedir.</p>
                    </div>
                    <div class="srv-card">
                        <div class="srv-icon-wrap srv-blue">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456z"/>
                            </svg>
                        </div>
                        <h3>Kapıya Teslimat</h3>
                        <p>Kesim sonrası etleriniz hijyenik şekilde paketlenerek belirlediğiniz adrese teslim edilir.</p>
                    </div>
                    <div class="srv-card">
                        <div class="srv-icon-wrap srv-purple">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                            </svg>
                        </div>
                        <h3>Hisse Sistemi</h3>
                        <p>Büyük baş kurbanlarda 7 kişiye kadar hisse imkânıyla herkes kurban ibadetini kolayca ifa edebilir.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ═══ GÖRSEL BÖLÜM (saf görsel + açıklama) ═══ -->
        <section class="visual-sec">
            <div class="visual-bg-pattern">
                <GeomStar :size="500" opacity="0.04" color="#b8860b" />
            </div>
            <div class="container">
                <div class="visual-grid">
                    <div class="visual-images">
                        <div class="vi-full">
                            <img src="/images/saf2.jpg" alt="Kurban hizmetleri" loading="lazy" />
                            <div class="vi-badge-overlay">
                                <span class="vi-badge-icon">☽</span>
                                <span class="vi-badge-label">Kurban Bayramı 2025</span>
                            </div>
                        </div>
                    </div>
                    <div class="visual-text">
                        <span class="sec-tag">Hakkımızda</span>
                        <h2 class="sec-title text-start">Güvenilir Kurban<br />Hizmetinde Lider</h2>
                        <p>Eyvan Kurban Hizmetleri olarak, Kurban Bayramı'nda İslami esaslara uygun, şeffaf ve güvenilir hizmet anlayışıyla yanınızdayız. Kurban seçiminden kesim ve teslimatına kadar tüm süreci sizin için yönetiyoruz.</p>
                        <div class="feature-list">
                            <div class="fl-item">
                                <span class="fl-check">✓</span>
                                <span>Online kurban seçimi ve rezervasyon sistemi</span>
                            </div>
                            <div class="fl-item">
                                <span class="fl-check">✓</span>
                                <span>Küpe numarasıyla şeffaf takip</span>
                            </div>
                            <div class="fl-item">
                                <span class="fl-check">✓</span>
                                <span>7 kişiye kadar hisseli kurban imkânı</span>
                            </div>
                            <div class="fl-item">
                                <span class="fl-check">✓</span>
                                <span>Taksitli ödeme seçeneği</span>
                            </div>
                            <div class="fl-item">
                                <span class="fl-check">✓</span>
                                <span>Profesyonel kesim ve paketleme</span>
                            </div>
                        </div>
                        <router-link :to="{ name: 'posts.index' }" class="btn-gold" style="margin-top:1.75rem; display:inline-flex">
                            Kurbanları Görüntüle
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"/>
                            </svg>
                        </router-link>
                    </div>
                </div>
            </div>
        </section>

        <!-- ═══ KURBAN SÜRECİ ═══ -->
        <section class="steps-sec">
            <div class="container">
                <div class="sec-header">
                    <span class="sec-tag">Nasıl Çalışır?</span>
                    <h2 class="sec-title">Kolay 4 Adımda Kurbanınız</h2>
                </div>
                <div class="steps-grid">
                    <div class="step-card">
                        <div class="step-num">01</div>
                        <div class="step-icon">🔍</div>
                        <h4>Kurban Seçin</h4>
                        <p>Listelenen kurbanlar arasından bütçenize ve tercihlerinize uygun olanı seçin.</p>
                    </div>
                    <div class="step-arrow">→</div>
                    <div class="step-card">
                        <div class="step-num">02</div>
                        <div class="step-icon">📋</div>
                        <h4>Hisse Alın</h4>
                        <p>Tam kurban veya 7 hisseye kadar paylaşımlı seçeneklerden birini tercih edin.</p>
                    </div>
                    <div class="step-arrow">→</div>
                    <div class="step-card">
                        <div class="step-num">03</div>
                        <div class="step-icon">✂️</div>
                        <h4>Kesim Günü</h4>
                        <p>Belirlenen gün ve saatte İslami kurallara uygun profesyonel kesim gerçekleştirilir.</p>
                    </div>
                    <div class="step-arrow">→</div>
                    <div class="step-card">
                        <div class="step-num">04</div>
                        <div class="step-icon">🚚</div>
                        <h4>Teslimat</h4>
                        <p>Hijyenik paketleme sonrası evinize veya belirlediğiniz adrese teslim edilir.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ═══ EID MUBARAK CTA ═══ -->
        <section class="cta-sec">
            <div class="cta-bg" :style="{ backgroundImage: `url('/images/wp4846734.webp')` }"></div>
            <div class="cta-overlay"></div>
            <div class="cta-geo">
                <GeomStar :size="600" opacity="0.06" color="#fff" />
            </div>
            <div class="cta-inner">
                <div class="cta-arabic">عِيدٌ مُبَارَكٌ</div>
                <h2 class="cta-title">Kurban Bayramınız Mübarek Olsun</h2>
                <p class="cta-sub">Yerinizi ayırtın, ibadetinizi gönül rahatlığıyla ifa edin.</p>
                <router-link :to="{ name: 'posts.index' }" class="btn-gold">
                    Hemen Rezervasyon Yapın
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"/>
                    </svg>
                </router-link>
            </div>
        </section>

        <!-- ═══ FOOTER ═══ -->
        <footer class="site-footer">
            <div class="footer-geo">
                <GeomStar :size="300" opacity="0.05" color="#fff" />
            </div>
            <div class="container">
                <div class="footer-grid">
                    <div class="footer-brand-col">
                        <div class="footer-brand">
                            <span class="fb-crescent">☽</span>
                            <strong>Eyvan Kurban</strong>
                        </div>
                        <p class="footer-desc">İslami esaslara uygun, güvenilir ve şeffaf kurban hizmetleri.</p>
                        <div class="footer-arabic-small">بِسْمِ اللَّهِ</div>
                    </div>
                    <div class="footer-links-col">
                        <h6>Hızlı Erişim</h6>
                        <ul>
                            <li><router-link :to="{ name: 'posts.index' }">Kurbanlar</router-link></li>
                            <li><router-link :to="{ name: 'login' }">Giriş Yap</router-link></li>
                            <li><router-link :to="{ name: 'register' }">Kayıt Ol</router-link></li>
                        </ul>
                    </div>
                    <div class="footer-info-col">
                        <h6>Bilgi</h6>
                        <ul>
                            <li>Veteriner Onaylı Hayvanlar</li>
                            <li>7 Hissedar / Kurban</li>
                            <li>Kapıya Teslimat</li>
                            <li>İslami Usul Kesim</li>
                        </ul>
                    </div>
                </div>
                <div class="footer-bottom">
                    <p>© {{ new Date().getFullYear() }} Eyvan Kurban Hizmetleri — Tüm hakları saklıdır.</p>
                    <div class="footer-bottom-arabic">اللَّهُ أَكْبَرُ</div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { defineComponent, h } from 'vue'

// İslami geometrik yıldız SVG bileşeni (inline)
const GeomStar = defineComponent({
    props: { size: { default: 200 }, opacity: { default: 0.1 }, color: { default: '#b8860b' } },
    setup(props) {
        return () => h('svg', {
            width: props.size, height: props.size,
            viewBox: '0 0 200 200',
            style: { opacity: props.opacity }
        }, [
            // 8 köşeli İslami yıldız
            h('polygon', {
                points: '100,10 118,45 155,30 140,67 175,85 140,103 155,140 118,125 100,160 82,125 45,140 60,103 25,85 60,67 45,30 82,45',
                fill: 'none',
                stroke: props.color,
                'stroke-width': '1.5'
            }),
            h('polygon', {
                points: '100,30 113,60 145,50 135,80 165,90 135,100 145,130 113,120 100,150 87,120 55,130 65,100 35,90 65,80 55,50 87,60',
                fill: 'none',
                stroke: props.color,
                'stroke-width': '0.8',
                opacity: '0.6'
            }),
            h('circle', {
                cx: 100, cy: 100, r: 25,
                fill: 'none',
                stroke: props.color,
                'stroke-width': '1'
            })
        ])
    }
})
</script>

<style scoped>
* { box-sizing: border-box; }
.landing { font-family: 'Nunito', sans-serif; }
.container { max-width: 1140px; margin: 0 auto; padding: 0 1.5rem; }

/* ── HERO ── */
.hero {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    text-align: center;
}
.hero-bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
}
.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        160deg,
        rgba(10, 20, 10, 0.82) 0%,
        rgba(20, 45, 20, 0.75) 50%,
        rgba(5, 15, 5, 0.88) 100%
    );
}
.hero-geo {
    position: absolute;
    pointer-events: none;
}
.hero-geo-left  { left: -80px; top: 50%; transform: translateY(-50%); }
.hero-geo-right { right: -120px; top: 50%; transform: translateY(-50%); }

.hero-inner {
    position: relative;
    z-index: 2;
    color: #fff;
    padding: 2rem 1rem;
    max-width: 780px;
    width: 100%;
}

.hero-badge-wrap {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(184, 134, 11, 0.25);
    border: 1px solid rgba(212, 175, 55, 0.45);
    padding: 0.4rem 1.1rem;
    border-radius: 2rem;
    margin-bottom: 1.5rem;
    backdrop-filter: blur(6px);
}
.hero-crescent {
    color: #d4af37;
    font-size: 1rem;
}
.hero-badge-text {
    font-size: 0.8rem;
    font-weight: 700;
    color: #d4af37;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.hero-title {
    font-size: clamp(2.5rem, 6vw, 4.5rem);
    font-weight: 900;
    line-height: 1.1;
    margin-bottom: 1.25rem;
    text-shadow: 0 2px 20px rgba(0, 0, 0, 0.5);
    letter-spacing: -0.5px;
}
.hero-title-accent {
    background: linear-gradient(135deg, #d4af37, #f5d06e, #b8860b);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.hero-sub {
    font-size: 1.1rem;
    opacity: 0.85;
    line-height: 1.75;
    max-width: 580px;
    margin: 0 auto 2rem;
}

.hero-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 3rem;
}

/* Altın Buton */
.btn-gold {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #b8860b, #d4af37, #b8860b);
    background-size: 200% auto;
    color: #1a0f00;
    text-decoration: none;
    padding: 0.8rem 1.85rem;
    border-radius: 0.55rem;
    font-weight: 800;
    font-size: 0.95rem;
    border: none;
    cursor: pointer;
    transition: background-position 0.4s, transform 0.15s, box-shadow 0.2s;
    box-shadow: 0 4px 20px rgba(212, 175, 55, 0.35);
    letter-spacing: 0.2px;
}
.btn-gold:hover {
    background-position: right center;
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(212, 175, 55, 0.5);
    color: #1a0f00;
}
.btn-ghost-white {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.1);
    border: 1.5px solid rgba(255, 255, 255, 0.45);
    color: #fff;
    text-decoration: none;
    padding: 0.8rem 1.85rem;
    border-radius: 0.55rem;
    font-weight: 700;
    font-size: 0.95rem;
    transition: background 0.2s;
    backdrop-filter: blur(6px);
}
.btn-ghost-white:hover { background: rgba(255, 255, 255, 0.2); color: #fff; }

/* Hero Stats */
.hero-stats {
    display: inline-flex;
    align-items: center;
    gap: 1.5rem;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 1rem;
    padding: 0.85rem 1.75rem;
    backdrop-filter: blur(8px);
    flex-wrap: wrap;
    justify-content: center;
}
.hero-stat { text-align: center; }
.hs-num { display: block; font-size: 1.35rem; font-weight: 900; color: #d4af37; line-height: 1; }
.hs-label { display: block; font-size: 0.7rem; color: rgba(255,255,255,0.65); margin-top: 3px; letter-spacing: 0.3px; }
.hero-stat-divider { width: 1px; height: 36px; background: rgba(255,255,255,0.15); }

/* Scroll */
.hero-scroll {
    position: absolute;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
    z-index: 2;
}
.scroll-dot {
    width: 6px;
    height: 6px;
    background: rgba(212, 175, 55, 0.7);
    border-radius: 50%;
    margin: 0 auto;
    animation: scrollBounce 2s infinite;
}
@keyframes scrollBounce {
    0%, 100% { transform: translateY(0); opacity: 1; }
    50% { transform: translateY(10px); opacity: 0.4; }
}

/* ── İLETİŞİM HERO ── */
.contact-hero {
    position: relative;
    padding: 6rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    overflow: hidden;
    min-height: 480px;
}
.contact-hero-bg {
    position: absolute;
    inset: 0;
    background-image: url('/bg.jpeg');
    background-size: cover;
    background-position: center;
    transform: scale(1.03);
}
.contact-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(160deg, rgba(5,15,5,0.87) 0%, rgba(10,35,10,0.80) 50%, rgba(5,15,5,0.90) 100%);
}
.contact-hero-inner {
    position: relative;
    z-index: 2;
    max-width: 600px;
    width: 100%;
    color: #fff;
}
.ch-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: rgba(212,175,55,0.15);
    border: 1px solid rgba(212,175,55,0.35);
    color: #d4af37;
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 0.35rem 0.9rem;
    border-radius: 2rem;
    margin-bottom: 1.25rem;
}
.ch-title {
    font-size: clamp(1.75rem, 4vw, 2.75rem);
    font-weight: 900;
    margin-bottom: 0.75rem;
    text-shadow: 0 2px 16px rgba(0,0,0,0.4);
}
.ch-sub {
    color: rgba(255,255,255,0.7);
    font-size: 0.975rem;
    line-height: 1.7;
    margin-bottom: 2.5rem;
}
.ch-contact-card {
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 1.25rem;
    padding: 1.75rem 2rem;
    backdrop-filter: blur(12px);
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    align-items: center;
}
.ch-person {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.ch-avatar {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, #b8860b, #d4af37);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    font-weight: 900;
    color: #1a0f00;
    flex-shrink: 0;
    box-shadow: 0 4px 16px rgba(212,175,55,0.35);
}
.ch-person-info { display: flex; flex-direction: column; text-align: left; gap: 3px; }
.ch-name { font-size: 1.1rem; font-weight: 800; color: #fff; }
.ch-role { font-size: 0.78rem; color: rgba(255,255,255,0.55); }
.ch-divider { width: 100%; height: 1px; background: rgba(255,255,255,0.1); }
.ch-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
    justify-content: center;
    width: 100%;
}
.ch-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.75rem 1.5rem;
    border-radius: 0.65rem;
    font-size: 0.9rem;
    font-weight: 800;
    text-decoration: none;
    transition: transform 0.15s, box-shadow 0.2s, opacity 0.15s;
    flex: 1;
    justify-content: center;
    min-width: 160px;
}
.ch-btn:hover { transform: translateY(-2px); opacity: 0.92; }
.ch-btn-call {
    background: rgba(255,255,255,0.15);
    border: 1.5px solid rgba(255,255,255,0.3);
    color: #fff;
}
.ch-btn-call:hover { background: rgba(255,255,255,0.22); color: #fff; }
.ch-btn-wp {
    background: #25d366;
    color: #fff;
    box-shadow: 0 4px 20px rgba(37,211,102,0.35);
}
.ch-btn-wp:hover { box-shadow: 0 8px 28px rgba(37,211,102,0.5); color: #fff; }

/* ── BİSMİLLAH BAND ── */
.bismillah-band {
    background: linear-gradient(135deg, #0d2b0d, #1a4a1a, #0d2b0d);
    padding: 1.25rem 1.5rem;
    text-align: center;
}
.band-inner {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1.25rem;
    flex-wrap: wrap;
    max-width: 900px;
    margin: 0 auto;
}
.band-arabic {
    font-size: 1.35rem;
    color: #d4af37;
    letter-spacing: 2px;
    font-style: italic;
}
.band-sep { color: rgba(212, 175, 55, 0.5); font-size: 0.8rem; }
.band-text { color: rgba(255,255,255,0.8); font-size: 0.875rem; font-style: italic; }

/* ── HİZMETLER ── */
.services-sec {
    padding: 6rem 1.5rem;
    background: #fafaf7;
    position: relative;
}
.sec-header { text-align: center; margin-bottom: 3.5rem; }
.sec-tag {
    display: inline-block;
    background: rgba(184, 134, 11, 0.12);
    color: #8b6914;
    font-size: 0.75rem;
    font-weight: 800;
    padding: 0.3rem 0.9rem;
    border-radius: 2rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 0.75rem;
}
.sec-title {
    font-size: clamp(1.6rem, 3vw, 2.2rem);
    font-weight: 900;
    color: #0d2b0d;
    margin-bottom: 0.75rem;
    line-height: 1.25;
}
.sec-sub { color: #6c757d; font-size: 1rem; margin: 0; }

.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
}
.srv-card {
    background: #fff;
    border-radius: 1rem;
    padding: 2rem 1.5rem;
    border: 1px solid #e9ecef;
    transition: transform 0.25s, box-shadow 0.25s;
    position: relative;
    overflow: hidden;
}
.srv-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #d4af37, #b8860b);
    transform: scaleX(0);
    transition: transform 0.3s;
}
.srv-card:hover { transform: translateY(-6px); box-shadow: 0 12px 32px rgba(0,0,0,0.1); }
.srv-card:hover::before { transform: scaleX(1); }
.srv-icon-wrap {
    width: 56px;
    height: 56px;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.25rem;
}
.srv-green  { background: #d3f9d8; color: #2f9e44; }
.srv-gold   { background: #fff3cd; color: #b8860b; }
.srv-blue   { background: #dde4f5; color: #3b5bdb; }
.srv-purple { background: #f3d9fa; color: #7950f2; }
.srv-card h3 { font-size: 1.05rem; font-weight: 800; color: #0d2b0d; margin-bottom: 0.6rem; }
.srv-card p  { font-size: 0.875rem; color: #6c757d; line-height: 1.65; margin: 0; }

/* ── GÖRSEL ── */
.visual-sec {
    padding: 6rem 1.5rem;
    background: #fff;
    position: relative;
    overflow: hidden;
}
.visual-bg-pattern {
    position: absolute;
    right: -80px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
}
.visual-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
}
@media (max-width: 768px) { .visual-grid { grid-template-columns: 1fr; } }

.visual-images { position: relative; }
.vi-full { position: relative; border-radius: 1.25rem; overflow: hidden; box-shadow: 0 12px 48px rgba(0,0,0,0.15); }
.vi-full img {
    width: 100%;
    height: 480px;
    object-fit: cover;
    display: block;
}
.vi-badge-overlay {
    position: absolute;
    bottom: 1.25rem;
    left: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(13, 43, 13, 0.85);
    border: 1px solid rgba(212, 175, 55, 0.4);
    backdrop-filter: blur(6px);
    border-radius: 2rem;
    padding: 0.45rem 1rem;
}
.vi-badge-icon { font-size: 1.1rem; color: #d4af37; }
.vi-badge-label { font-size: 0.8rem; color: rgba(255,255,255,0.9); font-weight: 700; }

.visual-text .sec-title { margin-top: 0.5rem; }
.visual-text p { color: #495057; line-height: 1.75; margin-bottom: 1.25rem; }
.feature-list { display: flex; flex-direction: column; gap: 0.6rem; }
.fl-item {
    display: flex;
    align-items: flex-start;
    gap: 0.6rem;
    font-size: 0.9rem;
    color: #344040;
    font-weight: 500;
}
.fl-check {
    color: #2f9e44;
    font-weight: 900;
    flex-shrink: 0;
    margin-top: 1px;
}

/* ── ADIMLAR ── */
.steps-sec {
    padding: 6rem 1.5rem;
    background: linear-gradient(135deg, #0a1f0a, #122812, #0a1f0a);
    position: relative;
    overflow: hidden;
}
.steps-sec .sec-tag { background: rgba(212,175,55,0.15); color: #d4af37; }
.steps-sec .sec-title { color: #fff; }
.steps-grid {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
    justify-content: center;
}
.step-card {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(212, 175, 55, 0.2);
    border-radius: 1rem;
    padding: 2rem 1.5rem;
    text-align: center;
    flex: 1;
    min-width: 180px;
    max-width: 220px;
    position: relative;
    transition: background 0.25s;
}
.step-card:hover { background: rgba(212, 175, 55, 0.08); }
.step-num {
    position: absolute;
    top: -1px;
    left: 1.25rem;
    font-size: 0.7rem;
    font-weight: 900;
    color: #d4af37;
    letter-spacing: 1px;
    background: linear-gradient(135deg, #0d2b0d, #1a4a1a);
    border: 1px solid rgba(212,175,55,0.3);
    padding: 0.2rem 0.55rem;
    border-radius: 0 0 0.4rem 0.4rem;
}
.step-icon { font-size: 2rem; margin-bottom: 0.75rem; }
.step-card h4 { font-size: 0.95rem; font-weight: 800; color: #fff; margin-bottom: 0.5rem; }
.step-card p { font-size: 0.8rem; color: rgba(255,255,255,0.6); line-height: 1.55; margin: 0; }
.step-arrow {
    font-size: 1.5rem;
    color: rgba(212, 175, 55, 0.4);
    flex-shrink: 0;
}
@media (max-width: 600px) { .step-arrow { display: none; } }

/* ── CTA ── */
.cta-sec {
    position: relative;
    padding: 7rem 1.5rem;
    text-align: center;
    overflow: hidden;
}
.cta-bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
}
.cta-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(160deg, rgba(10,25,10,0.88), rgba(20,60,20,0.82), rgba(10,25,10,0.9));
}
.cta-geo {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    pointer-events: none;
}
.cta-inner {
    position: relative;
    z-index: 2;
    max-width: 640px;
    margin: 0 auto;
    color: #fff;
}
.cta-arabic {
    font-size: 2.5rem;
    color: #d4af37;
    letter-spacing: 3px;
    margin-bottom: 1rem;
    text-shadow: 0 2px 12px rgba(212,175,55,0.3);
}
.cta-title {
    font-size: clamp(1.6rem, 3.5vw, 2.5rem);
    font-weight: 900;
    margin-bottom: 0.85rem;
    text-shadow: 0 2px 12px rgba(0,0,0,0.4);
}
.cta-sub {
    color: rgba(255,255,255,0.75);
    margin-bottom: 2rem;
    font-size: 1rem;
    line-height: 1.65;
}

/* ── FOOTER ── */
.site-footer {
    background: #050f05;
    padding: 4rem 1.5rem 2rem;
    position: relative;
    overflow: hidden;
}
.footer-geo {
    position: absolute;
    right: -50px;
    bottom: -50px;
    pointer-events: none;
}
.footer-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    gap: 3rem;
    margin-bottom: 3rem;
}
@media (max-width: 768px) { .footer-grid { grid-template-columns: 1fr; gap: 2rem; } }

.footer-brand {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    margin-bottom: 0.85rem;
}
.fb-crescent { font-size: 1.5rem; color: #d4af37; }
.footer-brand strong { font-size: 1.15rem; color: #fff; font-weight: 800; }
.footer-desc { color: rgba(255,255,255,0.5); font-size: 0.875rem; line-height: 1.65; margin-bottom: 1rem; }
.footer-arabic-small { color: #d4af37; font-size: 1rem; letter-spacing: 1px; opacity: 0.7; }

.footer-links-col h6,
.footer-info-col h6 {
    color: rgba(255,255,255,0.9);
    font-weight: 800;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 1rem;
}
.footer-links-col ul,
.footer-info-col ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.footer-links-col li,
.footer-info-col li {
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
    color: rgba(255,255,255,0.45);
}
.footer-links-col a {
    color: rgba(255,255,255,0.45);
    text-decoration: none;
    transition: color 0.15s;
}
.footer-links-col a:hover { color: #d4af37; }

.footer-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-top: 1px solid rgba(255,255,255,0.08);
    padding-top: 1.5rem;
    flex-wrap: wrap;
    gap: 0.5rem;
}
.footer-bottom p { color: rgba(255,255,255,0.3); font-size: 0.8rem; margin: 0; }
.footer-bottom-arabic { color: rgba(212, 175, 55, 0.4); font-size: 0.9rem; letter-spacing: 1px; }
</style>
