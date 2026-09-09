<?php
/**
 * Shared product repository. A products table is preferred when available;
 * the legacy catalog keeps the existing site usable until that table exists.
 */
function getProducts(PDO $pdo): array
{
    try {
        $columns = $pdo->query("SHOW COLUMNS FROM products")->fetchAll();
        if ($columns) {
            $rows = $pdo->query(
                'SELECT id, name, category, price, rating, badge, image, description AS `desc`, in_stock
                 FROM products ORDER BY id ASC'
            )->fetchAll();
            if ($rows) {
                return array_map(static function (array $product): array {
                    $product['price'] = (float) $product['price'];
                    $product['rating'] = (int) ($product['rating'] ?? 0);
                    $product['in_stock'] = (bool) ($product['in_stock'] ?? true);
                    $product['badge'] = $product['badge'] ?? '';
                    $product['desc'] = $product['desc'] ?? '';
                    return $product;
                }, $rows);
            }
        }
    } catch (PDOException $e) {
        // The fallback below supports the current installation without a product table.
    }

    return [
        ['id'=>1,'name'=>'Aviator Sunglasses','category'=>'More Accessories','price'=>9.90,'rating'=>5,'badge'=>'','image'=>'https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&w=800&q=80','desc'=>'Classic unisex aviator sunglasses with UV400 protection and lightweight metal frame.','in_stock'=>true],
        ['id'=>2,'name'=>'Contrast Backpack','category'=>'Bags','price'=>69.90,'rating'=>5,'badge'=>'','image'=>'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=800&q=80','desc'=>'Durable canvas backpack featuring rich leather trims and spacious multi-compartment storage.','in_stock'=>true],
        ['id'=>3,'name'=>'Contrasting Design T-Shirt','category'=>'T-shirt','price'=>95.90,'rating'=>5,'badge'=>'Hot','image'=>'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=800&q=80','desc'=>'Vibrant floral printed quarter-sleeve blouse made from premium soft viscose fabric.','in_stock'=>true],
        ['id'=>4,'name'=>'Contrasting Design T-Shirt','category'=>'T-shirt','price'=>95.90,'rating'=>4,'badge'=>'','image'=>'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=800&q=80','desc'=>'Minimalist relaxed fit cotton t-shirt with subtle chest graphic typography.','in_stock'=>true],
        ['id'=>5,'name'=>'Cotton Sweater','category'=>'Men','price'=>19.90,'rating'=>5,'badge'=>'','image'=>'https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?auto=format&fit=crop&w=800&q=80','desc'=>'Cozy crewneck cotton knit sweater in dark denim blue for crisp autumn layering.','in_stock'=>true],
        ['id'=>6,'name'=>'Cropped Denim Jumpsuit','category'=>'Women','price'=>89.59,'rating'=>5,'badge'=>'','image'=>'https://images.unsplash.com/photo-1576995853123-5a10305d93c0?auto=format&fit=crop&w=800&q=80','desc'=>'Stylish wide-leg denim jumpsuit with adjustable cami shoulder straps and side pockets.','in_stock'=>true],
        ['id'=>7,'name'=>'Embroidered Flowy Jacket','category'=>'Women','price'=>56.89,'rating'=>4,'badge'=>'','image'=>'https://images.unsplash.com/photo-1548883354-7622d03aca27?auto=format&fit=crop&w=800&q=80','desc'=>'Lightweight boho embroidered jacket with delicate lace details and open front design.','in_stock'=>true],
        ['id'=>8,'name'=>'Floral Short Jumpsuit','category'=>'Women','price'=>97.99,'rating'=>5,'badge'=>'Hot','image'=>'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=800&q=80','desc'=>'Playful short floral romper with wrap front V-neckline and elastic waist cinching.','in_stock'=>true],
        ['id'=>9,'name'=>'Furry Hooded Parka','category'=>'Clothing','price'=>77.98,'rating'=>5,'badge'=>'','image'=>'https://images.unsplash.com/photo-1539533018447-63fcce2678e3?auto=format&fit=crop&w=800&q=80','desc'=>'Warm winter parka with faux-fur lined detachable hood and water-resistant outer shell.','in_stock'=>true],
        ['id'=>10,'name'=>'Glitter Decorated Shoes','category'=>'Shoes','price'=>56.90,'rating'=>4,'badge'=>'','image'=>'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?auto=format&fit=crop&w=800&q=80','desc'=>'Elegant low block-heel pumps adorned with subtle glitter finish for evening wear.','in_stock'=>true],
        ['id'=>11,'name'=>'Leather Shop Bag','category'=>'Bags','price'=>59.90,'rating'=>5,'badge'=>'','image'=>'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=800&q=80','desc'=>'Handcrafted cognac leather bucket bag with top drawstring closure and shoulder strap.','in_stock'=>true],
        ['id'=>12,'name'=>"Mango Women's Bag",'category'=>'Bags','price'=>79.90,'rating'=>5,'badge'=>'Out Of Stock','image'=>'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?auto=format&fit=crop&w=800&q=80','desc'=>'Structured nude pink tote handbag with dual top handles and magnetic clasp.','in_stock'=>false],
        ['id'=>13,'name'=>'Metallic Frame Glasses','category'=>'More Accessories','price'=>29.90,'rating'=>5,'badge'=>'Sale','image'=>'https://images.unsplash.com/photo-1572635196237-14b3f281503f?auto=format&fit=crop&w=800&q=80','desc'=>'Sleek silver metallic optical frames with blue light blocking clear lenses.','in_stock'=>true],
        ['id'=>14,'name'=>'Wool Knit Beanie','category'=>'Hats & Gloves','price'=>18.50,'rating'=>4,'badge'=>'','image'=>'https://images.unsplash.com/photo-1576871337632-b9aef4c17ab9?auto=format&fit=crop&w=800&q=80','desc'=>'Warm ribbed wool beanie hat with fold-over cuff in neutral oat beige.','in_stock'=>true],
        ['id'=>15,'name'=>'Classic Leather Belt','category'=>'Wallets & Cases','price'=>24.90,'rating'=>5,'badge'=>'','image'=>'https://images.unsplash.com/photo-1624222247344-550fb60583dc?auto=format&fit=crop&w=800&q=80','desc'=>'Full-grain Italian leather belt featuring brushed brass roller buckle.','in_stock'=>true]
    ];
}
