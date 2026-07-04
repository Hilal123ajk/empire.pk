<?php

declare(strict_types=1);

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Support\SeoMeta;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return view('pages.about', [
            'seo' => SeoMeta::forPage(
                title: 'About Us',
                description: 'Learn about Empire.pk — Pakistan\'s trusted online store for genuine mobile accessories, phone cases, screen protectors, and more.',
                canonical: route('store.pages.about'),
                keywords: 'about Empire.pk, mobile accessories Pakistan, genuine products',
            ),
        ]);
    }

    public function contact(): View
    {
        return view('pages.contact', [
            'seo' => SeoMeta::forPage(
                title: 'Contact Us',
                description: 'Get in touch with Empire.pk. Call, WhatsApp, or email us for orders, product questions, and customer support across Pakistan.',
                canonical: route('store.pages.contact'),
                keywords: 'contact Empire.pk, customer support, WhatsApp, mobile accessories Pakistan',
            ),
        ]);
    }

    public function faqs(): View
    {
        return view('pages.faqs', [
            'seo' => SeoMeta::forPage(
                title: 'FAQs',
                description: 'Frequently asked questions about Empire.pk — genuine products, cash on delivery, shipping, returns, and ordering in Pakistan.',
                canonical: route('store.pages.faqs'),
                keywords: 'FAQs, cash on delivery, shipping Pakistan, genuine mobile accessories',
            ),
            'faqs' => $this->faqItems(),
        ]);
    }

    public function returns(): View
    {
        return view('pages.returns', [
            'seo' => SeoMeta::forPage(
                title: 'Returns & Exchange',
                description: 'Empire.pk return and exchange policy. Simple returns if a product does not match your requirements.',
                canonical: route('store.pages.returns'),
                keywords: 'returns, exchange, refund policy, Empire.pk',
            ),
        ]);
    }

    public function shipping(): View
    {
        return view('pages.shipping', [
            'seo' => SeoMeta::forPage(
                title: 'Shipping Policy',
                description: 'Empire.pk shipping policy. Nationwide delivery across Pakistan with flat delivery fee and cash on delivery.',
                canonical: route('store.pages.shipping'),
                keywords: 'shipping policy, delivery Pakistan, cash on delivery, Empire.pk',
            ),
        ]);
    }

    /**
     * @return array<int, array{question: string, answer: string}>
     */
    private function faqItems(): array
    {
        return [
            [
                'question' => 'Are the products genuine?',
                'answer' => 'Yes — every product sold on Empire.pk is 100% genuine. We source directly from trusted suppliers and authorized distributors. Whether you are buying a phone case, tempered glass, charger, or AirPods accessory, you receive the real product with proper quality and packaging. We do not sell copies, replicas, or low-grade imitations. If you ever have doubts about authenticity, contact us before or after your order and we will gladly assist.',
            ],
            [
                'question' => 'Do you offer Cash on Delivery (COD)?',
                'answer' => 'Yes, we offer Cash on Delivery across all major cities in Pakistan including Lahore, Karachi, Islamabad, Rawalpindi, Faisalabad, Multan, Sialkot, and Gujranwala. Simply place your order online, and pay the courier when your package arrives. No advance payment or bank transfer is required.',
            ],
            [
                'question' => 'How long does delivery take?',
                'answer' => 'Orders are typically processed within 1–2 business days. Delivery to major cities usually takes 2–4 business days. For other areas, delivery may take 4–7 business days depending on your location and courier coverage. You will receive updates via phone or WhatsApp once your order is dispatched.',
            ],
            [
                'question' => 'What if I receive a damaged or wrong item?',
                'answer' => 'If your product arrives damaged, defective, or different from what you ordered, contact us on WhatsApp or phone immediately. We will arrange a replacement or return at no extra cost. Please share photos of the item and packaging so we can resolve your issue quickly.',
            ],
            [
                'question' => 'Can I order without creating an account?',
                'answer' => 'Yes. Empire.pk does not require you to create an account to shop. Simply browse products, add items to your cart, and checkout with your name, phone number, and delivery address. We use your phone number to confirm and track your order.',
            ],
        ];
    }
}
