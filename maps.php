<?php
include 'backend/db_config.php';
// Ganti: Logika otentikasi
get_header("Maps");
get_top_bar("Maps");

$user_id = $_SESSION['user_id'] ?? null;
$activities = [];
if ($user_id) {
    $activities_result = $conn->query("SELECT map_id, activity_text FROM map_activities WHERE user_id = $user_id ORDER BY id DESC");
    while ($row = $activities_result->fetch_assoc()) {
        $activities[$row['map_id']][] = $row['activity_text'];
    }
}
?>

<div class="container-maps">
    <h2>🗺️ World Maps</h2>
    <?php if (isset($_SESSION['success'])): ?>
        <p style="color: green;"><?= $_SESSION['success'] ?></p>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <p style="color: red;"><?= $_SESSION['error'] ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <div class="kotak_bg">
        <img src="assets/images/background2.png" alt="Background Image" style="width: 100%; height: auto;">
    </div>

    <div class="map-card" id="map1" style="background-color: var(--color-secondary);">
        <div class="map-header" data-bg-url="assets/images/maps_1.png"> Royal Citadel Stronghold
            <button class="toggle-btn" type="button">[+]</button>
        </div>
        <div class="map-content">
            <p>A heavily guarded fortress filled with elite soldiers and explosive traps. Players fight through defenses, uncover hidden tunnels, steal the Knightblade, and activate the ancient Grand Gate to escape.</p>
            
            <div class="map-details">
                <div class="map-image-placeholder"><img src="assets/images/maps_1.png"></div> 
                <div class="map-activities">
                    <h4>Activities:</h4>
                    <ul>
                        <li>• Battle elite royal guards</li>
                        <li>• Dodge firebombs and traps</li>
                        <li>• Infiltrate the armory</li>
                        <li>• Steal the Knightblade</li>
                        <li>• Open the ancient Grand Gate to escape</li>
                        <?php foreach ($activities[1] ?? [] as $activity): ?>
                        <li>• <?= htmlspecialchars($activity) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            
            <form class="pixel-form" action="backend/maps.php" method="POST">
                <input type="hidden" name="map_id" value="1">
                <input type="text" name="activity" placeholder="Add an Activity..." required>
                <button type="submit" class="pixel-button">Add Activity</button>
            </form>
        </div>
    </div>

    <div class="map-card" id="map2" style="background-color: var(--color-secondary);">
        <div class="map-header" data-bg-url="assets/images/maps_2.png"> Arcane Witchspire Haven
            <button class="toggle-btn" type="button">[+]</button>
        </div>
        <div class="map-content">
            <p>A magical home packed with potions, spells, and arcane traps. Players brew powerful mixtures, battle rogue witches, explore twisting chambers, and seek the forbidden Grimoire of Eternal Wisdom.</p>
            
            <div class="map-details">
                <div class="map-image-placeholder"><img src="assets/images/maps_2.png"></div> <div class="map-activities">
                    <h4>Activities:</h4>
                    <ul>
                        <li>• Brew magical potions</li>
                        <li>• Use anti-magic shields</li>
                        <li>• Fight rogue witches</li>
                        <li>• Explore trapped chambers</li>
                        <li>• Retrieve the Grimoire</li>
                        <?php foreach ($activities[2] ?? [] as $activity): ?>
                        <li>• <?= htmlspecialchars($activity) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            
            <form class="pixel-form" action="backend/maps.php" method="POST">
                <input type="hidden" name="map_id" value="2">
                <input type="text" name="activity" placeholder="Add an Activity..." required>
                <button type="submit" class="pixel-button">Add Activity</button>
            </form>
        </div>
    </div>
    
    <div class="map-card" id="map3" style="background-color: var(--color-secondary);">
        <div class="map-header" data-bg-url="assets/images/maps_3.png"> Abyssal Voidrealm
            <button class="toggle-btn" type="button">[+]</button>
        </div>
        <div class="map-content">
            <p>A distorted dark dimension with shifting terrain and shadow creatures. Players resist corruption, absorb void energy for new powers, and stabilize the collapsing rift to escape the abyss.</p>
            
            <div class="map-details">
                <div class="map-image-placeholder"><img src="assets/images/maps_3.png"></div> <div class="map-activities">
                    <h4>Activities:</h4>
                    <ul>
                        <li>• Navigate shifting void terrain</li>
                        <li>• Resist corruption</li>
                        <li>• Absorb dark energy</li>
                        <li>• Fight shadow creatures</li>
                        <li>• Stabilize the rift to escape the abyss</li>
                        <?php foreach ($activities[3] ?? [] as $activity): ?>
                        <li>• <?= htmlspecialchars($activity) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            
            <form class="pixel-form" action="backend/maps.php" method="POST">
                <input type="hidden" name="map_id" value="3">
                <input type="text" name="activity" placeholder="Add an Activity..." required>
                <button type="submit" class="pixel-button">Add Activity</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle map content
        document.querySelectorAll('.toggle-btn').forEach(btn => {
            btn.addEventListener('click', function(event) {
                event.preventDefault();
                const header = this.parentElement;
                const content = header.nextElementSibling;
                if (content && content.classList.contains('map-content')) {
                    content.classList.toggle('active');
                }
            });
        });

        // Check hash to open specific map
        const hash = window.location.hash;
        if (hash) {
            const mapId = hash.substring(1); // remove #
            const mapElement = document.getElementById(mapId);
            if (mapElement) {
                const content = mapElement.querySelector('.map-content');
                if (content) {
                    content.classList.add('active');
                    // Scroll to the map
                    mapElement.scrollIntoView({ behavior: 'smooth' });
                }
            }
        }
    });
</script>

<?php get_footer(); ?>