//Pega a ref do banco
ref = firebase.database().ref("interdictionsTeste");

function deleteInterventionFromFirebase(key) {
    console.log("aaaa");
    let intervention = ref.child(key);
    var remove = intervention.remove();
    if (remove) {
        return true;
    } else {
        return false;
        console.log("não removeu");
    }
}

// db.ref("-Users/-KUanJA9egwmPsJCxXpv").update({ displayName: "New trainer" });
// firebase.database().ref("PIN/`-KrnO...Ho/PIN").set(30);
function updateInterventionStatusFirebase(key, value) {
    var change;

    if (value == "true") {
        change = false;
    } else if (value == "false") {
        change = true;
    }

    var update = firebase
        .database()
        .ref("interdictionsTeste/" + key)
        .update({
            status: change
        });

    if (update) {
        return true;
    } else {
        return false;
    }
    // console.log(teste);

    // var update = teste.set({ status: change });

    // // var update = db.ref("interdictionsTeste/" + key).update({ status: change });

    // if (update) {
    //     console.log("updated");
    // } else {
    //     console.log("not updated");
    // }
    // var update = intervention.update();
    // if (update) {
    //     return true;
    // } else {
    //     return false;
    //     console.log("não removeu");
    // }
}
