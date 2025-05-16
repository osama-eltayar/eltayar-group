document.addEventListener('DOMContentLoaded', function() {
    const langToggle = document.getElementById('langToggle');
    const htmlElement = document.documentElement;
    
    // Unified data for both languages
    const appData = {
        'supervisors': [
            {
                'nameAr': 'أسامة الطيار',
                'nameEn': 'First Supervisor',
                'phone': '+966 50 123 4567',
                'phoneLink': '+201110032691',
                'whatsappLink': '201110032691'
            },
            {
                'nameAr': 'أحمد الطيار',
                'nameEn': 'Second Supervisor',
                'phone': '+966 50 765 4321',
                'phoneLink': '+201003732794',
                'whatsappLink': '201003732794'
            }
        ],
        'hotels': [
            {
                'nameAr': 'الانصار جولدن تيوليب',
                'nameEn': 'Al Ansar Golden Tulip',
                'addressAr': 'شارع العنبرية، المدينة المنورة',
                'addressEn': 'Al-Anbariyah Street, Madinah',
                'gps': '24.4672,39.6150'
            },
            {
                'nameAr': 'أبراج مكة هيلتون',
                'nameEn': 'Makkah Towers Hilton',
                'addressAr': 'شارع إبراهيم الخليل، مكة المكرمة',
                'addressEn': 'Ibrahim Al-Khalil Street, Makkah',
                'gps': '21.4267,39.8295'
            },
            {
                'nameAr': 'العزيزية بلازا',
                'nameEn': 'Al Aziziyah Plaza',
                'addressAr': 'حي العزيزية، مكة المكرمة',
                'addressEn': 'Al-Aziziyah District, Makkah',
                'gps': '21.3890,39.8579'
            }
        ],
        'camps': [
            {
                'nameAr': 'مخيم الرحمة',
                'nameEn': 'Al-Rahma Camp',
                'addressAr': 'منطقة 204، منى',
                'addressEn': 'Area 204, Mina',
                'gps': '21.4133,39.8782'
            },
            {
                'nameAr': 'مخيم النور',
                'nameEn': 'Al-Noor Camp',
                'addressAr': 'الشارع الرئيسي، عرفات',
                'addressEn': 'Main Street, Arafat',
                'gps': '21.3548,39.9841'
            }
        ],
        'mutawwif': {
            'nameAr': 'اسم المطوف',
            'nameEn': 'Mutawwif Name',
            'phone': '+966 55 123 4567',
            'phoneLink': '+966551234567',
            'whatsappLink': '966551234567'
        }
    };
    
    // Text translations
    const translations = {
        'ar': {
            'pageTitle': 'بطاقة إرشاد',
            'cardTitle': 'بطاقة إرشاد',
            'langButton': 'English',
            'supervisorsTitle': 'المشرفين',
            'callButton': 'اتصال',
            'whatsappButton': 'واتساب',
            'hotelsTitle': 'الفنادق',
            'hotelLocation1': 'فندق المدينة',
            'hotelLocation2': 'فندق مكة',
            'hotelLocation3': 'فندق العزيزية',
            'campsTitle': 'المخيمات',
            'campPrefix1': 'منى - ',
            'campPrefix2': 'عرفات - ',
            'mapButton': 'الموقع على الخريطة',
            'mutawwifTitle': 'المطوف',
            'footer': 'حجاج بيت الله الحرام'
        },
        'en': {
            'pageTitle': 'Guide Card',
            'cardTitle': 'Guide Card',
            'langButton': 'العربية',
            'supervisorsTitle': 'Supervisors',
            'callButton': 'Call',
            'whatsappButton': 'WhatsApp',
            'hotelsTitle': 'Hotels',
            'hotelLocation1': 'Madinah Hotel',
            'hotelLocation2': 'Makkah Hotel',
            'hotelLocation3': 'Aziziyah Hotel',
            'campsTitle': 'Camps',
            'campPrefix1': 'Mina - ',
            'campPrefix2': 'Arafat - ',
            'mapButton': 'View on Map',
            'mutawwifTitle': 'Mutawwif',
            'footer': 'Hajj Pilgrims'
        }
    };
    
    // Function to populate card with data
    function populateCard(lang = 'ar') {
        // Update supervisor data
        document.querySelectorAll('.supervisor-name').forEach((element, index) => {
            element.textContent = appData.supervisors[index][lang === 'ar' ? 'nameAr' : 'nameEn'];
        });
        
        document.querySelectorAll('.supervisor-value').forEach((element, index) => {
            element.textContent = appData.supervisors[index].phone;
        });
        
        document.querySelectorAll('.supervisor-call').forEach((element, index) => {
            element.href = `tel:${appData.supervisors[index].phoneLink}`;
        });
        
        document.querySelectorAll('.supervisor-whatsapp').forEach((element, index) => {
            element.href = `https://wa.me/${appData.supervisors[index].whatsappLink}`;
        });
        
        // Update hotel data
        document.querySelectorAll('.hotel-name').forEach((element, index) => {
            element.textContent = appData.hotels[index][lang === 'ar' ? 'nameAr' : 'nameEn'];
        });
        
        document.querySelectorAll('.hotel-location').forEach((element, index) => {
            element.textContent = translations[lang][`hotelLocation${index + 1}`];
        });
        
        // Update hotel addresses
        const addressTexts = document.querySelectorAll('.hotel-address p');
        addressTexts.forEach((element, index) => {
            const addressText = appData.hotels[index][lang === 'ar' ? 'addressAr' : 'addressEn'];
            element.innerHTML = `<i class="fas fa-map-marker-alt"></i> ${addressText}`;
        });
        
        document.querySelectorAll('.hotel-map').forEach((element, index) => {
            element.href = `https://maps.google.com/?q=${appData.hotels[index].gps}`;
        });
        
        // Update camp data
        document.querySelectorAll('.camp-name').forEach((element, index) => {
            const campName = appData.camps[index][lang === 'ar' ? 'nameAr' : 'nameEn'];
            const campPrefix = translations[lang][`campPrefix${index + 1}`];
            element.textContent = campPrefix + campName;
        });
        
        // Update camp addresses
        const campAddressTexts = document.querySelectorAll('.camp-address p');
        campAddressTexts.forEach((element, index) => {
            const addressText = appData.camps[index][lang === 'ar' ? 'addressAr' : 'addressEn'];
            element.innerHTML = `<i class="fas fa-map-marker-alt"></i> ${addressText}`;
        });
        
        document.querySelectorAll('.camp-map').forEach((element, index) => {
            element.href = `https://maps.google.com/?q=${appData.camps[index].gps}`;
        });
        
        // Update mutawwif data
        document.querySelector('.mutawwif-name').textContent = appData.mutawwif[lang === 'ar' ? 'nameAr' : 'nameEn'];
        document.querySelector('.mutawwif-value').textContent = appData.mutawwif.phone;
        document.querySelector('.mutawwif-call').href = `tel:${appData.mutawwif.phoneLink}`;
        document.querySelector('.mutawwif-whatsapp').href = `https://wa.me/${appData.mutawwif.whatsappLink}`;
    }
    
    // Function to update all text content
    function updateLanguage(lang) {
        // Update HTML attributes
        htmlElement.setAttribute('lang', lang);
        htmlElement.setAttribute('dir', lang === 'ar' ? 'rtl' : 'ltr');
        
        // Update page title
        document.title = translations[lang].pageTitle;
        
        // Update Bootstrap CSS for RTL/LTR
        const bootstrapLink = document.querySelector('link[href*="bootstrap"]');
        if (lang === 'ar') {
            bootstrapLink.href = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css';
        } else {
            bootstrapLink.href = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css';
        }
        
        // Update card title
        document.querySelector('.card-header h3').textContent = translations[lang].cardTitle;
        
        // Update language toggle button
        langToggle.innerHTML = `<i class="fas fa-language me-1"></i>${translations[lang].langButton}`;
        
        // Update supervisors section
        document.querySelector('.supervisors .section-title').textContent = translations[lang].supervisorsTitle;
        
        // Update contact buttons
        const callButtons = document.querySelectorAll('.contact-buttons a:first-child');
        callButtons.forEach(button => {
            button.innerHTML = `<i class="fas fa-phone-alt"></i> ${translations[lang].callButton}`;
        });
        
        const whatsappButtons = document.querySelectorAll('.contact-buttons a:last-child');
        whatsappButtons.forEach(button => {
            button.innerHTML = `<i class="fab fa-whatsapp"></i> ${translations[lang].whatsappButton}`;
        });
        
        // Update hotels section
        document.querySelector('.hotels .section-title').textContent = translations[lang].hotelsTitle;
        
        // Update camps section
        document.querySelector('.camps .section-title').textContent = translations[lang].campsTitle;
        
        // Update map buttons
        const mapButtons = document.querySelectorAll('.hotel-card a.btn, .camp-card a.btn');
        mapButtons.forEach(button => {
            button.innerHTML = `<i class="fas fa-map"></i> ${translations[lang].mapButton}`;
        });
        
        // Update mutawwif section
        document.querySelector('.mutawwif .section-title').textContent = translations[lang].mutawwifTitle;
        
        // Update footer
        document.querySelector('.card-footer p').textContent = translations[lang].footer;
        
        // Update all dynamic content with the new language
        populateCard(lang);
    }
    
    // Initialize the card with data
    populateCard();
    
    // Language toggle click event
    langToggle.addEventListener('click', function() {
        const currentLang = htmlElement.getAttribute('lang');
        const newLang = currentLang === 'ar' ? 'en' : 'ar';
        updateLanguage(newLang);
    });
}); 