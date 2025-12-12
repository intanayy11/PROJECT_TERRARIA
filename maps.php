<?php
include 'backend/db_config.php';
// Ganti: Logika otentikasi
get_header("Maps");
get_top_bar("Maps");
?>

<div class="container">
    <h2>🗺️ World Maps</h2>

    <div class="map-card" style="background-color: var(--color-secondary);">
        <div class="map-header" data-bg-url="assets/images/bg_citadel.jpg"> Royal Citadel Stronghold
            <span>[+]</span>
        </div>
        <div class="map-content">
            <p>A heavily guarded fortress filled with elite soldiers and explosive traps. Players fight through defenses, uncover hidden tunnels, steal the Knightblade, and activate the ancient Grand Gate to escape.</p>
            
            <div class="map-details">
                <div class="map-image-placeholder">Gambar Map Citadel</div> <div class="map-activities">
                    <h4>Activities:</h4>
                    <ul>
                        <li>• Battle elite royal guards</li>
                        <li>• Dodge firebombs and traps</li>
                        <li>• Infiltrate the armory</li>
                        <li>• Steal the Knightblade</li>
                        <li>• Open the ancient Grand Gate to escape</li>
                    </ul>
                </div>
            </div>
            
            <form class="pixel-form">
                <input type="text" placeholder="Add an Activity..." required>
                <button type="submit" class="pixel-button">Add Activity</button>
            </form>
        </div>
    </div>

    <div class="map-card" style="background-color: var(--color-secondary);">
        <div class="map-header" data-bg-url="assets/images/bg_witchspire.jpg"> Arcane Witchspire Haven
            <span>[+]</span>
        </div>
        <div class="map-content">
            <p>A magical home packed with potions, spells, and arcane traps. Players brew powerful mixtures, battle rogue witches, explore twisting chambers, and seek the forbidden Grimoire of Eternal Wisdom.</p>
            
            <div class="map-details">
                <div class="map-image-placeholder">Gambar Map Witchspire</div> <div class="map-activities">
                    <h4>Activities:</h4>
                    <ul>
                        <li>• Brew magical potions</li>
                        <li>• Use anti-magic shields</li>
                        <li>• Fight rogue witches</li>
                        <li>• Explore trapped chambers</li>
                        <li>• Retrieve the Grimoire</li>
                    </ul>
                </div>
            </div>
            
            <form class="pixel-form">
                <input type="text" placeholder="Add an Activity..." required>
                <button type="submit" class="pixel-button">Add Activity</button>
            </form>
        </div>
    </div>
    
    <div class="map-card" style="background-color: var(--color-secondary);">
        <div class="map-header" data-bg-url="assets/images/bg_voidrealm.jpg"> Abyssal Voidrealm
            <span>[+]</span>
        </div>
        <div class="map-content">
            <p>A distorted dark dimension with shifting terrain and shadow creatures. Players resist corruption, absorb void energy for new powers, and stabilize the collapsing rift to escape the abyss.</p>
            
            <div class="map-details">
                <div class="map-image-placeholder">Gambar Map Voidrealm</div> <div class="map-activities">
                    <h4>Activities:</h4>
                    <ul>
                        <li>• Navigate shifting void terrain</li>
                        <li>• Resist corruption</li>
                        <li>• Absorb dark energy</li>
                        <li>• Fight shadow creatures</li>
                        <li>• Stabilize the rift to escape the abyss</li>
                    </ul>
                </div>
            </div>
            
            <form class="pixel-form">
                <input type="text" placeholder="Add an Activity..." required>
                <button type="submit" class="pixel-button">Add Activity</button>
            </form>
        </div>
    </div>
</div>

<?php get_footer(); ?>