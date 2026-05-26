<?php

namespace Database\Seeders;

use App\Models\{User, Category, Page, Faq, Setting, AppointmentType, NailShape, NailSize};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Laetitia Morel',
            'email' => 'laetitia@letimnails.fr',
            'password' => Hash::make('admin1234'),
            'phone' => '07 56 81 35 64',
            'is_admin' => true,
        ]);

        // Pages
        $pages = [
            ['title' => 'Conditions Générales de Vente', 'slug' => 'conditions-generales-de-vente', 'content' => '<h2>Conditions Générales de Vente</h2><p>Les présentes conditions générales de vente s\'appliquent à toutes les ventes conclues sur le site LetiMNails.</p><p>Le site internet https://letimnails.fr est un service de : LETI M NAILS - 1 chemin des rives, 12300 Bouillac</p><p>Le site internet LETI M NAILS commercialise des PRESS ON NAILS.</p>'],
            ['title' => 'Mentions Légales', 'slug' => 'mentions-legales', 'content' => '<h2>Mentions Légales</h2><p>LetiMNails est une auto-entreprise sous gestion de : Laetitia Morel - 1 chemin des rives - 12300 Bouillac</p><p>Tél : 07 56 81 35 64 - Email : support@letimnails.fr</p><p>Directrice de la publication : Laetitia Morel</p><p>Hébergement : ABhD - 1 chemin des rives - 12300 Bouillac - France</p>'],
            ['title' => 'Politique de Confidentialité', 'slug' => 'privacy-policy', 'content' => '<h2>Politique de Confidentialité</h2><p>Vos données personnelles sont collectées et traitées dans le cadre de la gestion de votre compte et de vos commandes sur letimnails.fr.</p><p>Conformément au RGPD, vous disposez d\'un droit d\'accès, de rectification et de suppression de vos données.</p>'],
            ['title' => 'Informations sur la livraison', 'slug' => 'informations-sur-la-livraison', 'content' => '<h2>Informations sur la livraison</h2><p>Livraison offerte dès 50€ d\'achat en France Métropolitaine. Expédition sous 2 à 5 jours ouvrés.</p><p>Nous utilisons des protections papier bulle pour protéger vos articles durant le transport.</p>'],
            ['title' => 'Remboursements & retours', 'slug' => 'remboursements_retours', 'content' => '<h2>Remboursements & retours</h2><p>Conformément à la législation en vigueur, vous disposez d\'un délai de rétractation de 14 jours à compter de la réception de votre commande.</p><p>Les articles personnalisés ne peuvent pas être retournés.</p>'],
            ['title' => 'Télécharger mes données', 'slug' => 'telecharger-mes-donnees', 'content' => '<h2>Télécharger mes données</h2><p>Dans le cadre d\'une demande de téléchargement, seules les informations stockées sur le site Internet letimnails.fr seront disponibles.</p><p>Vous recevrez un email contenant un lien de téléchargement valide 7 jours.</p>'],
        ];

        foreach ($pages as $page) {
            Page::create($page + ['is_active' => true, 'template' => 'default']);
        }

        // FAQs
        $faqs = [
            ['question' => 'Comment commander des press on nails personnalisés ?', 'answer' => 'Vous avez deux options : 1) Commander des articles disponibles directement depuis la boutique. 2) Demander un devis pour des capsules entièrement personnalisées.'],
            ['question' => 'Quels sont les délais de fabrication ?', 'answer' => 'Les délais de fabrication sont de 2 à 5 jours ouvrés pour les produits en stock, et de 7 à 15 jours ouvrés pour les commandes personnalisées.'],
            ['question' => 'Comment entretenir mes press on nails ?', 'answer' => 'Évitez le contact prolongé avec l\'eau et les produits chimiques. Pour nettoyer, utilisez un coton avec du dissolvant sans acétone.'],
            ['question' => 'Puis-je réutiliser mes press on nails ?', 'answer' => 'Oui ! Si vous les retirez avec précaution et que vous les conservez dans leur boîte, vous pouvez les réutiliser plusieurs fois.'],
            ['question' => 'Comment choisir la bonne taille ?', 'answer' => 'Nous recommandons d\'acheter notre sizing kit qui vous permet de trouver la taille parfaite pour chaque doigt.'],
        ];

        foreach ($faqs as $i => $faq) {
            Faq::create($faq + ['position' => $i, 'is_active' => true]);
        }

        // Appointment types
        $types = [
            ['name' => 'Américaine - Pose', 'slug' => 'americaine-pose', 'description' => 'Pose américaine complète', 'price' => 45, 'duration_minutes' => 90],
            ['name' => 'Américaine - Dépose', 'slug' => 'americaine-depose', 'description' => 'Dépose américaine', 'price' => 15, 'duration_minutes' => 30],
            ['name' => 'Semi gainage - Pose', 'slug' => 'semi-gainage-pose', 'description' => 'Pose semi gainage', 'price' => 55, 'duration_minutes' => 120],
            ['name' => 'Semi gainage - Dépose', 'slug' => 'semi-gainage-depose', 'description' => 'Dépose semi gainage', 'price' => 20, 'duration_minutes' => 30],
            ['name' => 'Semi sans gainage - Pose', 'slug' => 'semi-sans-gainage-pose', 'description' => 'Pose semi sans gainage', 'price' => 45, 'duration_minutes' => 90],
            ['name' => 'Semi sans gainage - Dépose', 'slug' => 'semi-sans-gainage-depose', 'description' => 'Dépose semi sans gainage', 'price' => 15, 'duration_minutes' => 30],
        ];

        foreach ($types as $type) {
            AppointmentType::create($type + ['is_active' => true]);
        }

        // Settings
        Setting::set('site_name', 'LetiMNails', 'general');
        Setting::set('contact_phone', '07 56 81 35 64', 'general');
        Setting::set('contact_email', 'support@letimnails.fr', 'general');
        Setting::set('contact_address', "58 Lotissement Armand Flottes\n12220 Les Albres", 'general');
        Setting::set('facebook_url', 'https://www.facebook.com/letimnails', 'general');
        Setting::set('instagram_url', 'https://www.instagram.com/leti_mnails/', 'general');
        Setting::set('youtube_url', 'https://www.youtube.com/@LetimNails', 'general');
        Setting::set('shipping_info', 'Dès 50€ d\'achat en France Métropolitaine', 'shipping');
        Setting::set('shipping_cost', 0, 'shipping');
        Setting::set('free_shipping_threshold', 50, 'shipping');

        // Nail Shapes
        $shapes = ['Coffin', 'Stiletto', 'Carré', 'Amande', 'Rond'];
        foreach ($shapes as $i => $name) {
            $shape = NailShape::create([
                'name' => $name,
                'slug' => strtolower($name),
                'position' => $i,
                'is_active' => true,
            ]);

            $sizes = ['Court', 'Medium', 'Long'];
            if ($name === 'Rond') $sizes = ['Extra court'];

            foreach ($sizes as $j => $size) {
                NailSize::create([
                    'nail_shape_id' => $shape->id,
                    'name' => $size,
                    'slug' => strtolower($name) . '-' . strtolower($size),
                    'position' => $j,
                ]);
            }
        }

        // Product categories
        $cats = ['Sets', 'Bijoux', 'Accessoires', 'Sizing Kits', 'Cartes cadeaux'];
        foreach ($cats as $i => $name) {
            Category::create([
                'name' => $name,
                'slug' => strtolower($name),
                'type' => 'product',
                'position' => $i,
                'is_active' => true,
            ]);
        }

        $this->command->info('Base de données initialisée avec succès !');
        $this->command->info('Admin: laetitia@letimnails.fr / admin1234');
    }
}
