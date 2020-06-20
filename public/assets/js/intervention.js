//Pega a ref do banco
ref = firebase.database().ref("interdictions");

function deleteInterventionFromFirebase(key) {
    let intervention = ref.child(key);
    var remove = intervention.remove();
    if (remove) {
        return true;
    } else {
        return false;
        console.log("não removeu");
    }
}

async function updateInterventionStatusFirebase(key, value) {
    var change;

    if (value == "true") {
        change = false;
    } else if (value == "false") {
        change = true;
    }

    var update = firebase
        .database()
        .ref("interdictions/" + key)
        .update({
            status: change
        });

    if (update) {
        return true;
    } else {
        return false;
    }
}
