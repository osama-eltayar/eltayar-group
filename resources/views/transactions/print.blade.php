<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إيصال استلام نقدية</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: white;
            color: #333;
            line-height: 1.4;
            font-size: 13px;
        }

        .receipt-container {
            width: 210mm;
            height: 297mm;
            margin: 0 auto;
            background: white;
            padding: 15mm;
            position: relative;
        }

        .receipt-header-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 25px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }

        .company-info {
            text-align: right;
            max-width: 60mm;
        }

        .company-name {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin-bottom: 6px;
        }

        .company-details {
            font-size: 11px;
            color: #666;
            line-height: 1.3;
        }

        .company-details div {
            margin-bottom: 3px;
        }

        .receipt-header {
            text-align: center;
            flex: 1;
        }

        .receipt-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #333;
        }

        .receipt-subtitle {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .receipt-number {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            background: #f5f5f5;
            padding: 6px 12px;
            border-radius: 4px;
            display: inline-block;
        }

        .receipt-body-section {
            flex: 1;
        }

        .receipt-body {
            margin-bottom: 25px;
        }

        .receipt-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .receipt-row:last-child {
            border-bottom: none;
        }

        .receipt-label {
            font-weight: 600;
            color: #333;
            font-size: 14px;
            min-width: 100px;
        }

        .receipt-value {
            font-weight: 700;
            color: #333;
            font-size: 14px;
            text-align: right;
            flex: 1;
        }

        .amount-section {
            background: #f8f9fa;
            border: 2px solid #333;
            margin: 20px 0;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
        }

        .amount-label {
            font-size: 16px;
            margin-bottom: 10px;
            font-weight: 600;
            color: #333;
        }

        .amount-value {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #333;
        }

        .amount-currency {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .amount-verbal {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            min-height: 18px;
        }

        .receipt-footer {
            margin-top: 30px;
            text-align: center;
        }

        .footer-text {
            font-size: 12px;
            color: #666;
            margin-bottom: 10px;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px solid #333;
        }

        .signature-box {
            text-align: center;
            flex: 1;
            margin: 0 15px;
        }

        .signature-line {
            width: 80%;
            height: 2px;
            background: #333;
            margin: 10px auto;
        }

        .signature-label {
            font-size: 12px;
            color: #333;
            font-weight: 600;
            margin-top: 8px;
        }

        .notices-section {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }

        .notices-title {
            font-size: 14px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
            text-align: center;
        }

        .notices-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .notices-list li {
            font-size: 11px;
            color: #666;
            margin-bottom: 5px;
            padding-right: 15px;
            position: relative;
            line-height: 1.3;
        }

        .notices-list li::before {
            content: "•";
            position: absolute;
            right: 0;
            top: 0;
            color: #333;
            font-weight: bold;
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #333;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 4px;
            font-family: 'Cairo', sans-serif;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }

        .print-button:hover {
            background: #555;
            transform: translateY(-1px);
        }

        @media print {
            .print-button {
                display: none;
            }
            body {
                background: white;
            }
            .receipt-container {
                box-shadow: none;
                margin: 0;
                padding: 10mm;
            }
        }

        @page {
            size: A4;
            margin: 0;
        }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">🖨️ طباعة الإيصال</button>

    <div class="receipt-container">
        <!-- Header Section -->
        <div class="receipt-header-section">
            <div class="company-info">
                <div class="company-name">شركة الطيار للسفر والسياحة</div>
                <div class="company-details">
                    <div>العنوان: الرياض - المملكة العربية السعودية</div>
                    <div>هاتف: +966 11 123 4567</div>
                    <div>البريد الإلكتروني: info@eltayar.com</div>
                </div>
            </div>

            <div class="receipt-header">
                <div class="receipt-title">إيصال استلام نقدية</div>
                <div class="receipt-subtitle">Cash Receipt</div>
                <div class="receipt-number">رقم الإيصال: #{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>

        <!-- Body Section -->
        <div class="receipt-body-section">
            <div class="receipt-body">
                <div class="receipt-row">
                    <span class="receipt-label">اسم العميل:</span>
                    <span class="receipt-value">{{ $transaction->client?->name_ar ?? 'غير محدد' }}</span>
                </div>

                <div class="receipt-row">
                    <span class="receipt-label">طريقة الدفع:</span>
                    <span class="receipt-value">{{ $transaction->payment_method->label() }}</span>
                </div>

                <div class="receipt-row">
                    <span class="receipt-label">تاريخ الإيصال:</span>
                    <span class="receipt-value">{{ $transaction->created_at->format('Y/m/d') }}</span>
                </div>

                <div class="receipt-row">
                    <span class="receipt-label">تاريخ الاستلام:</span>
                    <span class="receipt-value">{{ $transaction->created_at->format('Y/m/d') }}</span>
                </div>

                <div class="receipt-row">
                    <span class="receipt-label">عن:</span>
                    <span class="receipt-value">{{ $transaction->about ?? 'دفع مبلغ' }}</span>
                </div>

                <div class="amount-section">
                    <div class="amount-label">المبلغ المستلم</div>
                    <div class="amount-value">{{ $transaction->amount }}</div>
                    <div class="amount-currency">{{ $transaction->currency_code->value }}</div>
                    <div class="amount-verbal">
                        {{$transaction->amount_in_arabic}}
                    </div>
                </div>

                @if($transaction->notes)
                <div class="receipt-row">
                    <span class="receipt-label">ملاحظات:</span>
                    <span class="receipt-value">{{ $transaction->notes }}</span>
                </div>
                @endif
            </div>

            <div class="receipt-footer">
                <div class="footer-text">شكراً لثقتكم بنا</div>
                <div class="footer-text">Thank you for your trust</div>

                <div class="signature-section">
                    <div class="signature-box">
                        <div class="signature-label">اسم المستلم </div>
                        <div class="signature-line"></div>
                        <div class="signature-label">{{ $transaction->user?->name ?? 'غير محدد' }} </div>
                    </div>
                    <div class="signature-box">
                        <div class="signature-label">ختم الشركة</div>
                        <div class="signature-line"></div>
                    </div>
                </div>
            </div>

            <!-- Notices Section -->
            <div class="notices-section">
                <div class="notices-title">تنبيهات مهمة</div>
                <ul class="notices-list">
                    <li>يجب الاحتفاظ بهذا الإيصال كدليل على استلام المبلغ</li>
                    <li>لا يتم استرداد المبلغ بعد التوقيع على الإيصال</li>
                    <li>في حالة وجود أي استفسار، يرجى التواصل مع الشركة خلال 30 يوم</li>
                    <li>هذا الإيصال صالح لمدة سنة من تاريخ الإصدار</li>
                    <li>يجب التأكد من صحة جميع البيانات قبل التوقيع</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
