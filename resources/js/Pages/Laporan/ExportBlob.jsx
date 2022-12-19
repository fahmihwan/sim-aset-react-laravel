import axios from "axios";
export const ExportBlob = (url, nameFile) => {
    axios
        .get(url, {
            responseType: "blob",
        })
        .then((res) => {
            var myBlob = new Blob([res.data], { type: "text/xml" });
            var myReader = new FileReader();
            myReader.onload = function (event) {
                if (event.target.result == 0) {
                    alert("data tidak ditemukan");
                } else {
                    let blob = new Blob([res.data], {
                        type: res.headers["content-type"],
                    });
                    let link = document.createElement("a");
                    link.href = window.URL.createObjectURL(blob);
                    link.setAttribute("download", nameFile);
                    link.click();
                }
            };
            myReader.readAsText(myBlob);
        })
        .catch((err) => {
            alert(err);
        });
};
