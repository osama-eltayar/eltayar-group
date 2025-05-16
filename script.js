document.addEventListener('DOMContentLoaded', function() {
    const langToggle = document.getElementById('langToggle');
    const htmlElement = document.documentElement;
    
    // Text translations
    const translations = {
        'ar': {
            'pageTitle': 'بطاقة تعريفية لإرشاد التائهين',
            'cardTitle': 'بطاقة إرشاد التائهين',
            'langButton': 'English',
            'supervisorsTitle': 'المشرفين',
            'firstSupervisor': 'المشرف الأول',
            'secondSupervisor': 'المشرف الثاني',
            'phoneLabel': 'رقم الجوال:',
            'callButton': 'اتصال',
            'whatsappButton': 'واتساب',
            'hotelsTitle': 'الفنادق',
            'madinahHotel': 'فندق المدينة',
            'makkahHotel': 'فندق مكة',
            'aziziyahHotel': 'فندق العزيزية',
            'addressPrefix': 'العنوان:',
            'madinahAddress': 'شارع العنبرية، المدينة المنورة',
            'makkahAddress': 'شارع إبراهيم الخليل، مكة المكرمة',
            'aziziyahAddress': 'حي العزيزية، مكة المكرمة',
            'mapButton': 'الموقع على الخريطة',
            'mutawwifTitle': 'المطوف',
            'mutawwifName': 'اسم المطوف',
            'footer': 'حجاج بيت الله الحرام'
        },
        'en': {
            'pageTitle': 'Identification Card for Lost Pilgrims',
            'cardTitle': 'Lost Pilgrims Guide Card',
            'langButton': 'العربية',
            'supervisorsTitle': 'Supervisors',
            'firstSupervisor': 'First Supervisor',
            'secondSupervisor': 'Second Supervisor',
            'phoneLabel': 'Mobile:',
            'callButton': 'Call',
            'whatsappButton': 'WhatsApp',
            'hotelsTitle': 'Hotels',
            'madinahHotel': 'Madinah Hotel',
            'makkahHotel': 'Makkah Hotel',
            'aziziyahHotel': 'Aziziyah Hotel',
            'addressPrefix': 'Address:',
            'madinahAddress': 'Al-Anbariyah Street, Madinah',
            'makkahAddress': 'Ibrahim Al-Khalil Street, Makkah',
            'aziziyahAddress': 'Al-Aziziyah District, Makkah',
            'mapButton': 'View on Map',
            'mutawwifTitle': 'Mutawwif',
            'mutawwifName': 'Mutawwif Name',
            'footer': 'Hajj Pilgrims'
        }
    };
    
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
        langToggle.innerHTML = `<i class="fas fa-language"></i> ${translations[lang].langButton}`;
        
        // Update supervisors section
        document.querySelector('.supervisors .section-title').textContent = translations[lang].supervisorsTitle;
        document.querySelectorAll('.supervisor-name')[0].textContent = translations[lang].firstSupervisor;
        document.querySelectorAll('.supervisor-name')[1].textContent = translations[lang].secondSupervisor;
        
        // Update phone labels
        document.querySelectorAll('.label').forEach(label => {
            label.textContent = translations[lang].phoneLabel;
        });
        
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
        
        const hotelNames = document.querySelectorAll('.hotel-name');
        hotelNames[0].textContent = translations[lang].madinahHotel;
        hotelNames[1].textContent = translations[lang].makkahHotel;
        hotelNames[2].textContent = translations[lang].aziziyahHotel;
        
        // Update hotel addresses
        const addressTexts = document.querySelectorAll('.hotel-address p');
        addressTexts[0].innerHTML = `<i class="fas fa-map-marker-alt"></i> ${translations[lang].addressPrefix} ${translations[lang].madinahAddress}`;
        addressTexts[1].innerHTML = `<i class="fas fa-map-marker-alt"></i> ${translations[lang].addressPrefix} ${translations[lang].makkahAddress}`;
        addressTexts[2].innerHTML = `<i class="fas fa-map-marker-alt"></i> ${translations[lang].addressPrefix} ${translations[lang].aziziyahAddress}`;
        
        // Update map buttons
        const mapButtons = document.querySelectorAll('.hotel-card a.btn');
        mapButtons.forEach(button => {
            button.innerHTML = `<i class="fas fa-map"></i> ${translations[lang].mapButton}`;
        });
        
        // Update mutawwif section
        document.querySelector('.mutawwif .section-title').textContent = translations[lang].mutawwifTitle;
        document.querySelector('.mutawwif-name').textContent = translations[lang].mutawwifName;
        
        // Update footer
        document.querySelector('.card-footer p').textContent = translations[lang].footer;
    }
    
    // Language toggle click event
    langToggle.addEventListener('click', function() {
        const currentLang = htmlElement.getAttribute('lang');
        const newLang = currentLang === 'ar' ? 'en' : 'ar';
        updateLanguage(newLang);
    });
}); 