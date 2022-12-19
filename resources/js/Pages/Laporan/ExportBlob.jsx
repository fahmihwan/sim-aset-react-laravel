// import React from "react";

export const exportBlob = (props) => {
    console.log(props);
    // return <div>exportBlob</div>;
};

// import React from "react";

// const exportBlob = (props) => {
//     console.log(props);
// };

// export default exportBlob;

// axios
//     .get(
//         `/laporan/export_pdf_masuk?start_date=${data.start_date}&end_date=${data.end_date}`,
//         {
//             responseType: "blob",
//         }
//     )
//     .then((res) => {
//         var myBlob = new Blob([res.data], { type: "text/xml" });
//         var myReader = new FileReader();
//         myReader.onload = function (event) {
//             if (event.target.result == 0) {
//                 alert("data tidak ditemukan");
//             } else {
//                 let blob = new Blob([res.data], {
//                     type: res.headers["content-type"],
//                 });
//                 let link = document.createElement("a");
//                 link.href = window.URL.createObjectURL(blob);
//                 link.setAttribute("download", `laporan_masuk.pdf`);
//                 link.click();
//             }
//         };
//         myReader.readAsText(myBlob);
// })
// .catch((err) => {
//     alert(err);
// });
