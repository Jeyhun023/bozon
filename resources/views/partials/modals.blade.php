<div class="popup popup-delete">
    <div class="layer-popup"></div>
    <div class="popup-container">
        <div class="popup-content">
            <div class="popup-header bor-bottom-black-1">
                <h6>
                    Əminsiniz?
                </h6>
            </div>
            <p class="pop-p">
                Seçdiyiniz məlumat silinəcək və məlumat geri qaytarıla bilməz
            </p>
            <p class="pop-p pop-p2" style="display: none">
                Seçdiyiniz Categorinin childlari var onlarda silinecek.
            </p>
            <div class="pop-buttons">
                <button class="popup-close pop-button pop-gray-button">
                    Bağla
                </button>
                <form action="" method="post" id="deleteformdinamic" style="width: 100%;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" data-url="" class="pop-button deleteBtn pop-red-button">
                        Bəli, sil
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="popup popup-40">
    <div class="layer-popup"></div>
    <div class="popup-container">
        <div class="popup-content">
            <div class="popup-header bor-bottom-black-1">
                <h6>
                    Əminsiniz?
                </h6>
            </div>
            <p class="pop-p">
                Seçdiyiniz məlumatlar silinəcək və məlumat geri qaytarıla bilməz
            </p>
            <p class="pop-p pop-p3" style="display: none">
                Seçdiyiniz Categorinin childlari var onlarda silinecek.
            </p>
            <div class="pop-buttons">
                <button class="popup-close pop-button pop-gray-button">
                    Bağla
                </button>
                <button data-url="" data-storage="" class="pop-button pop-red-button pir"
                        onclick="deleteBtn41()">
                    Bəli, sil
                </button>
            </div>
        </div>
    </div>
</div>
<div class="popup popup-1">
    <div class="layer-popup"></div>
    <div class="popup-container">
        <div class="popup-content">
            <div class="popup-header bor-bottom-black-1">
                <h6>
                    Yeni ünvan yarat
                </h6>
            </div>
            <p class="pop-p">
                Dəyişikliklər yadda saxlanılmayıb. Çıxmaq istədiyinizdən əminsiniz?
            </p>
            <div class="pop-buttons">
                <button class="popup-close pop-button pop-blue-button">
                    Davam et
                </button>
                <a href="" class="pop-button pop-default-button">
                    Çıx
                </a>
            </div>
        </div>
    </div>
</div>
<div class="popup popup-2">
    <div class="layer-popup"></div>
    <div class="popup-container">
        <div class="popup-content">
            <div class="popup-header bor-bottom-black-1">
                <h6>
                    Yadda saxlanılsın?
                </h6>
            </div>
            <p class="pop-p">
                Dəyişiklikləri yadda saxlamaq üçün yadda saxla butonun klikləyin.
            </p>
            <div class="pop-buttons">
                <button class="popup-close pop-button pop-default-button">
                    Bağla
                </button>
                <a href="" class="pop-button pop-dblue-button">
                    Yadda saxla
                </a>
            </div>
        </div>
    </div>
</div>
<div class="popup popup-3">
    <div class="layer-popup"></div>
    <div class="popup-container">
        <div class="popup-content popup-success">
            <div class="popup-header bor-bottom-black-1">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12.8 24L22.4 32L35.2 16M24 46.4C11.6288 46.4 1.59998 36.3712 1.59998 24C1.59998 11.6288 11.6288 1.6 24 1.6C36.3712 1.6 46.4 11.6288 46.4 24C46.4 36.3712 36.3712 46.4 24 46.4Z"
                        stroke="#00D870"/>
                </svg>
                <h6>
                    Yadda saxlanıldı
                </h6>
            </div>
            <p class="pop-p">
                Əməliyyat uğurla tamamlandı
            </p>
            <div class="pop-buttons">
                <button class="popup-close pop-button pop-default-button">
                    Bağla
                </button>
            </div>
        </div>
    </div>
</div>
<div class="popup popup-4">
    <div class="layer-popup"></div>
    <div class="popup-container">
        <div class="popup-content">
            <div class="popup-header bor-bottom-black-1">
                <h6>
                    Əminsiniz?
                </h6>
            </div>
            <p class="pop-p">
                Seçdiyiniz məlumat silinəcək və məlumat geri qaytarıla bilməz
            </p>
            <div class="pop-buttons">
                <button class="popup-close pop-button pop-gray-button">
                    Bağla
                </button>
                <a href="" class="pop-button pop-red-button">
                    Bəli, sil
                </a>
            </div>
        </div>
    </div>
</div>
<div class="popup popup-5">
    <div class="layer-popup"></div>
    <div class="popup-container">
        <div class="popup-content popup-success">
            <div class="popup-header bor-bottom-black-1">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12.8 24L22.4 32L35.2 16M24 46.4C11.6288 46.4 1.59998 36.3712 1.59998 24C1.59998 11.6288 11.6288 1.6 24 1.6C36.3712 1.6 46.4 11.6288 46.4 24C46.4 36.3712 36.3712 46.4 24 46.4Z"
                        stroke="#00D870"/>
                </svg>
                <h6>
                    Silindi
                </h6>
            </div>
            <p class="pop-p">
                Əməliyyat uğurla tamamlandı
            </p>
            <div class="pop-buttons">
                <button class="popup-close pop-button pop-default-button">
                    Bağla
                </button>
            </div>
        </div>
    </div>
</div>

