<?php
require_once "../src/header.php";
require_once '../src/scripts/dbh.scr.php';
require_once '../src/scripts/getStuff.scr.php';
if (empty($_SESSION["userId"])) {
    header("Location: login.php");
    exit();
}
if (empty($_GET["usr"])) {
    $reciever = 0;
} else {
    $reciever = $_GET["usr"];
}
if ($reciever === $_SESSION["userId"]) {
    header("Location: chat.php");
}
$chats = getChats($conn);
$msgs = getChatMsg($reciever, $conn);
$otherInfo = getOtherInfo($reciever, $conn);
?>

<main class="d-flex flex-column p-3 px-4 flex-grow-1 overflow-hidden">
    <div class="d-flex flex-row gap-3 h-100">
        <button id="chatsToggle" class="btn btn-primary btn-lg d-lg-none" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasChats"><i class="bi bi-person-lines-fill"></i></button>
        <div class="border rounded d-flex flex-column p-2 offcanvas-lg offcanvas-start" tabindex="-1"
             id="offcanvasChats">
            <div class="d-flex flex-row align-items-center px-3">
                <h2 class="text-center mt-3">Active Chats:
                </h2>
                <button type="button" class="btn-close ms-auto d-lg-none" data-bs-dismiss="offcanvas"
                        data-bs-target="#offcanvasChats" aria-label="Close"></button>
            </div>
            <hr class="my-4">
            <div class="flex-grow-1 overflow-y-scroll ms-2">
                <div class="btn-group-vertical w-100">
                    <?php
                    for ($i = 0; $i < sizeof($chats); $i++) {
                        echo '
                        <a href="chat.php?usr=' . $chats[$i]['other'] . '" class="btn btn-dark chatProfileButton border">
                        <img class="profile_picture" alt="" src="' . $chats[$i]['userImage'] . '">
                        ' . $chats[$i]['userName'] . '</a>';
                    }
                    ?>
                </div>
            </div>
            <div id="newChat" class="border rounded px-2">
                <h5 class="mt-2">Start new chat:</h5>
                <form class="my-2" id="newChatForm">
                    <label for="newChatUsername" class="d-none"></label>
                    <label for="newChatId" class="d-none"></label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Username" id="newChatUsername">
                        <span class="input-group-text">or</span>
                        <input type="number" class="form-control" placeholder="Id" id="newChatId">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
                <div id="newChatHelp"></div>
            </div>
        </div>
        <div class="border flex-grow-1 rounded d-flex flex-column overflow-hidden">
            <?php
            if ($reciever !== 0) {
                echo '
                <header class="text-light d-flex flex-row align-items-center justify-content-center gap-2 p-3">
                <img class="chatPicture" alt="" src="' . $otherInfo[0]["userImage"] . '">
                <a href="../profiles/userpage.php?usr=' . $otherInfo[0]["userId"] . '"><h2>' . $otherInfo[0]["userName"] . '</h2></a>
            </header>
            <section id="chatArea" class="flex-grow-1 border-top overflow-y-scroll d-flex flex-column p-3 row-gap-3 overflow-x-hidden"></section>
            <form id="chatInsert" class="mt-auto">
                <div class="input-group rounded-0">
                    <label for="chatText"></label>
                    <input type="text" class="form-control rounded-0" placeholder="Type something..." id="chatText">
                    <button class="btn btn-success rounded-0" type="submit"><i class="bi bi-send"></i></button>
                </div>
            </form>
            ';
            }
            ?>
        </div>
    </div>
</main>
<script>
    const msgToId = <?php echo $reciever;?>;
    let oldMessages = 0;
    const interval = setInterval(getMessages, 1000);
    const objDiv = document.getElementById("chatArea");
    objDiv.scrollTop = objDiv.scrollHeight;

    $('#chatInsert').submit(function (e) {
        e.preventDefault();
        let msg = $("#chatText").val();
        if (!msg.length < 1) {
            $("#chatText").val('');
            $.ajax({
                type: "POST",
                url: "../src/scripts/chat.scr.php",
                data: {
                    "msg": msg,
                    "to": msgToId
                },
                dataType: "json",
            }).done(function (data) {
                console.log(data);
                getMessages();
            });
        }
    });

    function getMessages() {
        const other = <?php echo $reciever;?>;
        let tmpResult = null;
        if (other > 0) {
            return $.ajax({
                type: "POST",
                url: "../src/scripts/getCurrentChat.php",
                data: {"to": other},
                dataType: "json",
                success: function (data) {
                    tmpResult = data;
                    placeNewMessages(tmpResult);
                }
            });
        }
    }

    function placeNewMessages(tmpResult) {
        if (tmpResult.length !== oldMessages.length) {
            oldMessages = tmpResult;
            console.log("changes")
            console.log(oldMessages)
            $('#chatArea').html('');
            for (let j = 0; j < oldMessages.length; j++) {
                let date = "none";
                if (oldMessages[j]["hora"].split(" ")[0] === 1) {
                    date = 'Today at ' + oldMessages[j]["hora"].split(" ")[0];
                } else {
                    date = oldMessages[j]["hora"].split(" ")[1];
                }
                if (oldMessages[j]["sender"] == <?php echo $_SESSION["userId"];?>) {
                    $('#chatArea').append('<span class="ms-auto data">' + date + '</span>' +
                        '<span class="border py-2 px-3 d-flex flex-column bg-primary text-light msgMe">' +
                        '<span class="ms-auto sender text-truncate">' + oldMessages[j]["senderName"] + '</span>' +
                        '<span class="msgContent">' + oldMessages[j]["txt"] + '</span>' +
                        '</span>');

                } else {
                    $('#chatArea').append('<span class="me-auto data">' + date + '</span>' +
                        '<span class="border py-2 px-3 d-flex flex-column bg-secondary text-light msgOther">' +
                        '<span class="sender text-truncate">' + oldMessages[j]["senderName"] + '</span>' +
                        '<span class="msgContent">' + oldMessages[j]["txt"] + '</span>' +
                        '</span>');
                }
            }
            objDiv.scrollTop = objDiv.scrollHeight;
        }
    }
</script>
<script>
    $('#newChatUsername').change(function () {
        console.log("change");
        if ($(this).val().length > 0) {
            $('#newChatId').attr("disabled", true);
        } else {
            $('#newChatId').attr("disabled", false);
        }
    })
    $('#newChatId').change(function () {
        console.log("change");
        if ($(this).val().length > 0) {
            $('#newChatUsername').attr("disabled", true);
        } else {
            $('#newChatUsername').attr("disabled", false);
        }
    })
    $('#newChatForm').submit(function (e) {
        e.preventDefault();
        let uname = $('#newChatUsername').val();
        let uid = $('#newChatId').val();
        if (uid.length > 0) {
            $.ajax({
                type: "POST",
                url: "../src/scripts/searchUser.php",
                data: {"uid": uid},
                dataType: "json",
                success: function (data) {
                    if (data) {
                        window.location.replace("./chat.php?usr=" + uid);
                    } else {
                        $('#newChatHelp').html('' +
                            '<div class="alert alert-warning alert-dismissible fade show mt-2" role="alert" id="helpAlert">' +
                            '<i class="bi bi-exclamation-triangle-fill"></i> User does not exist!</a>' +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                            '</div>');
                        setInterval(function () {
                            $('#newChatHelp').html('')
                        }, 5000);
                    }
                }
            });
        } else if (uname.length > 0) {
            $.ajax({
                type: "POST",
                url: "../src/scripts/searchUser.php",
                data: {"uname": uname},
                dataType: "json",
                success: function (data) {
                    if (data) {
                        window.location.replace("./chat.php?usr=" + data[0]["userId"]);
                    } else {
                        $('#newChatHelp').html('' +
                            '<div class="alert alert-warning alert-dismissible fade show mt-2" role="alert" id="helpAlert">' +
                            '<i class="bi bi-exclamation-triangle-fill"></i> User does not exist!</a>' +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                            '</div>');
                        setInterval(function () {
                            $('#newChatHelp').html('')
                        }, 5000);
                    }
                }
            });
        }
        $(':input', this).not(':button, :submit, :reset, :hidden').val('').attr("disabled", false);
    })
</script>
<?php
require_once "../src/footer.php";
?>
