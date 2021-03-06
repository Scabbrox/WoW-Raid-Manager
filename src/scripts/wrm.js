function ClassIdToName(id) {
    switch (id) {
        case 1: return "Druid";
        case 2: return "Hunter";
        case 3: return "Mage";
        case 4: return "Paladin";
        case 5: return "Priest";
        case 6: return "Rogue";
        case 7: return "Shaman";
        case 8: return "Warlock";
        case 9: return "Warrior";
        case 10: return "Death Knight";
        case 11: return "Monk";
        case 12: return "Demon Hunter";
    }
}
function ClassIdToCss(id) {
    return ClassIdToName(id).toLowerCase().replace(/\s/g, '');
}

function BuildLootURL(item) {
    return "http://www.wowhead.com/item=" + item;
}

function RefreshLootLinks() {
    setTimeout(function () {
        $WowheadPower.refreshLinks();
    }, 25);
}