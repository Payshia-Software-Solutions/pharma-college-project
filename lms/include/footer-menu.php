<div id="bottomMenu" class="bottom-menu bg-light">
    <a href="./" class="menu-item <?= ($pageId == 1) ? 'active' : '' ?>"><i class="fa-solid fa-house menu-icon"></i></a>
    <a href="./profile" class="menu-item <?= ($pageId == 2) ? 'active' : '' ?>"><i class="fa-solid fa-user menu-icon"></i></a>
    <a href="./community" class="menu-item <?= ($pageId == 3) ? 'active' : '' ?>"><i class="fa-solid fa-users"></i></a>
    <a href="./delivery" class="menu-item <?= ($pageId == 4) ? 'active' : '' ?>"><i class="fa-solid fa-truck menu-icon"></i></a>
    <a href="/logout" class="menu-item <?= ($pageId == 5) ? 'active' : '' ?>"><i class="fa-solid fa-share-from-square menu-icon"></i></a>
</div>