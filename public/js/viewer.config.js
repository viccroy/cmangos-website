/**
* @package   cmangos-website
* @version   1.0
* @author    Viccroy
* @copyright 2023 Viccroy
* @link      https://github.com/viccroy/cmangos-website/
* @license   https://github.com/viccroy/cmangos-website/blob/master/LICENCE.txt Attribution-NonCommercial-NoDerivatives 4.0 International  
**/

class ModelViewer extends ZamModelViewer {
    setViewerLoadedCallback(cb) {
        this.renderer.models[0].setCustomizationsLoadedCallback(cb);
    }
    setSheath(a, b) {
        this.renderer.models[0].setSheath(a, b);
    }
    setParticlesEnabled(val) {
        this.renderer.models[0].setParticlesEnabled(val);
    }
    setAnimationPaused(val) {
        this.renderer.models[0].setAnimation("Stand");
        this.renderer.models[0].resetAnimation();
        this.renderer.models[0].setAnimPaused(val);
    }
}

if (!window.WH) {
    window.WH = {}
    window.WH.debug = function (...args) { /* console.log(args) */ };
    window.WH.Wow = { Item: { INVENTORY_TYPE_HEAD: 1, INVENTORY_TYPE_NECK: 2, INVENTORY_TYPE_SHOULDERS: 3, INVENTORY_TYPE_SHIRT: 4, INVENTORY_TYPE_CHEST: 5, INVENTORY_TYPE_WAIST: 6, INVENTORY_TYPE_LEGS: 7, INVENTORY_TYPE_FEET: 8, INVENTORY_TYPE_WRISTS: 9, INVENTORY_TYPE_HANDS: 10, INVENTORY_TYPE_FINGER: 11, INVENTORY_TYPE_TRINKET: 12, INVENTORY_TYPE_ONE_HAND: 13, INVENTORY_TYPE_SHIELD: 14, INVENTORY_TYPE_RANGED: 15, INVENTORY_TYPE_BACK: 16, INVENTORY_TYPE_TWO_HAND: 17, INVENTORY_TYPE_BAG: 18, INVENTORY_TYPE_TABARD: 19, INVENTORY_TYPE_ROBE: 20, INVENTORY_TYPE_MAIN_HAND: 21, INVENTORY_TYPE_OFF_HAND: 22, INVENTORY_TYPE_HELD_IN_OFF_HAND: 23, INVENTORY_TYPE_PROJECTILE: 24, INVENTORY_TYPE_THROWN: 25, INVENTORY_TYPE_RANGED_RIGHT: 26, INVENTORY_TYPE_QUIVER: 27, INVENTORY_TYPE_RELIC: 28, INVENTORY_TYPE_PROFESSION_TOOL: 29, INVENTORY_TYPE_PROFESSION_ACCESSORY: 30 } };
}

window.CONTENT_PATH = '/public/asset/';
const WH = window.WH;
const NOT_DISPLAYED_SLOTS = [2, 11, 12];
const modelingType = { ARMOR: 128, CHARACTER: 16, COLLECTION: 1024, HELM: 2, HUMANOIDNPC: 32, ITEM: 1, ITEMVISUAL: 512, NPC: 8, OBJECT: 64, PATH: 256, SHOULDER: 4 };
const characterPart = () => ({ "Face": "face", "Skin Color": "skin", "Hair Style": "hairStyle", "Hair Color": "hairColor", "Facial Hair": "facialStyle", "Features": "facialStyle", "Mustache": "facialStyle", "Beard": "facialStyle", "Sideburns": "facialStyle", "Face Shape": "facialStyle", "Eyebrow": "facialStyle" });
const optionalChaining = (choice) => choice ? choice.Id : undefined;

const getModelOptions = (character, fullOptions) => {
    const options = fullOptions.Options, missingChoice = [], returnOptions = [];
    for (const prop in characterPart()) {
        const part = options.find(e => e.Name === prop);
        if (!part)
            continue;
        const newOption = {
            optionId: part.Id,
            choiceId: (characterPart()[prop]) ? optionalChaining(part.Choices[character[characterPart()[prop]]]) : part.Choices[0].Id
        };
        if(newOption.choiceId === undefined)
            missingChoice.push(characterPart()[prop]);
        returnOptions.push(newOption)
    }
    return returnOptions
};

const getViewerOptions = (model, fullOptions) => {
    const {race, gender} = model;
    const characterItems = (model.items) ? model.items.filter(e => !NOT_DISPLAYED_SLOTS.includes(e[0])) : [];
    const options = getModelOptions(model, fullOptions);
    let charCustomization = { options: options };
    const returnOptions = {
        items: characterItems,
        models: {
            id: race * 2 - 1 + gender,
            type: modelingType.CHARACTER
        }
    };
    if(!model.noCharCustomization)
        returnOptions.charCustomization = charCustomization;
    return returnOptions;
};

const getCharacterOptions = async (race, gender) => {
    const index = race * 2 - 1 + gender;
    const path = `${window.CONTENT_PATH}meta/customization/${index}.json`;
    const options = await fetch(path).then((response) => response.json());
    return options.data ? options.data : options;
};

const generateViewer = async (aspect, container, model, extraOptions) => {
    let options, characterOptions; 
    if (model.id && model.type) {
        const { id, type } = model;
        options = { models: { id, type } };
    } else {
        const { race, gender } = model;
        characterOptions = await getCharacterOptions(race, gender);
        options = getViewerOptions(model, characterOptions);
    }

    const viewerOptions = {
        type: 2,
        contentPath: window.CONTENT_PATH,
        container: jQuery(container),
        aspect: aspect,
        hd: false,
        ...options,
        ...extraOptions
    };

    const viewer = await new ModelViewer(viewerOptions);
    return viewer;
}