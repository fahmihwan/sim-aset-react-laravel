import DangerButton from "@/Components/DangerButton";
import InputLabel from "@/Components/InputLabel";
import Pagination from "@/Components/Pagination";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, useForm, usePage } from "@inertiajs/inertia-react";
import axios from "axios";
import ExportBlob from "./exportBlob";

const LaporanMasuk = (props) => {
    const { errors, flash } = usePage().props;
    const { data, setData, get, post } = useForm({
        start_date: props.start_date || "",
        end_date: props.end_date || "",
    });

    console.log(ExportBlob);
    const handleChange = (e) => {
        setData(e.target.name, e.target.value);
    };

    const sendPrint = () => {
        data.start_date &&
            data.end_date &&
            axios
                .get(
                    `/laporan/export_pdf_masuk?start_date=${data.start_date}&end_date=${data.end_date}`,
                    {
                        responseType: "blob",
                    }
                )
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
                            link.setAttribute("download", `laporan_masuk.pdf`);
                            link.click();
                        }
                    };
                    myReader.readAsText(myBlob);
                })
                .catch((err) => {
                    alert(err);
                });
    };

    const sendSearch = () => {
        data.start_date && data.end_date && get("");
    };

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Laporan Aset Masuk
                </h2>
            }
        >
            <Head title="Aset Masuk" />

            <div className="pt-5 px-8  flex justify-between">
                <form
                    onSubmit={(e) => e.preventDefault()}
                    action=""
                    className="flex"
                >
                    <div className="mr-3">
                        <InputLabel forInput="start_date" value="start date" />
                        <input
                            type="date"
                            name="start_date"
                            placeholder="Type here"
                            className="input input-bordered w-full max-w-xs"
                            onChange={handleChange}
                            value={data.start_date}
                            required
                        />
                    </div>
                    <div className="mr-3">
                        <InputLabel forInput="end_date" value="end date" />
                        <input
                            type="date"
                            name="end_date"
                            placeholder="Type here"
                            className="input input-bordered w-full max-w-xs"
                            onChange={handleChange}
                            value={data.end_date}
                            required
                        />
                    </div>
                    <div className="flex items-end mr-3">
                        <button
                            onClick={sendSearch}
                            className="btn btn-primary"
                            value="cari"
                        >
                            Cari
                        </button>
                    </div>
                    <div className="flex items-end">
                        <button
                            onClick={sendPrint}
                            value="print"
                            className="btn btn-primary"
                        >
                            Print
                        </button>
                    </div>
                </form>
            </div>

            <div className="py-5">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-10">
                        <div className="overflow-x-auto">
                            <table className=" table table-compact w-full">
                                <thead>
                                    <tr>
                                        <th className="bg-neutral text-white">
                                            No
                                        </th>
                                        <th className="bg-neutral text-white">
                                            Tanggal Aset Masuk
                                        </th>
                                        <th className="bg-neutral text-white">
                                            Kode
                                        </th>
                                        <th className="bg-neutral text-white">
                                            Verfikasi
                                        </th>
                                        <th className="bg-neutral text-white">
                                            keterangan
                                        </th>
                                        <th className="bg-neutral text-white">
                                            List Aset
                                        </th>
                                        <th className="bg-neutral text-white">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {props.data.data.map((data, i) => {
                                        return (
                                            <tr key={i} className="p-0 ">
                                                <th>{i + 1}</th>
                                                <td className="p-0 ">
                                                    {data.tanggal_masuk}
                                                </td>
                                                <td className="p-0">
                                                    {data.kode_masuk}
                                                </td>
                                                <td className="p-0">
                                                    {data.verifikasi ? (
                                                        <span className="text-success font-bold">
                                                            sudah
                                                        </span>
                                                    ) : (
                                                        <span className="text-error font-bold">
                                                            belum
                                                        </span>
                                                    )}
                                                </td>
                                                <td className="p-0">
                                                    {data.keterangan}
                                                </td>
                                                <td className="py-4">
                                                    <table className="table table-compact w-full">
                                                        <thead>
                                                            <tr>
                                                                <td></td>
                                                                <td>kode</td>
                                                                <td>aset</td>
                                                                <td>ruangan</td>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            {data.detail_asets.map(
                                                                (d, i) => {
                                                                    return (
                                                                        <tr
                                                                            className="p-1 "
                                                                            key={
                                                                                i
                                                                            }
                                                                        >
                                                                            <th className="p-1 ">
                                                                                {i +
                                                                                    1}
                                                                            </th>
                                                                            <td className="p-1 ">
                                                                                {
                                                                                    d.kode_detail_aset
                                                                                }
                                                                            </td>
                                                                            <td className="p-1 ">
                                                                                {
                                                                                    d
                                                                                        .aset
                                                                                        .nama
                                                                                }
                                                                            </td>
                                                                            <td className="p-1 ">
                                                                                {
                                                                                    d
                                                                                        .ruangan
                                                                                        .ruangan
                                                                                }
                                                                            </td>
                                                                        </tr>
                                                                    );
                                                                }
                                                            )}
                                                        </tbody>
                                                    </table>
                                                </td>
                                                <td>
                                                    <button className="btn btn-primary btn-sm">
                                                        print
                                                    </button>
                                                </td>
                                            </tr>
                                        );
                                    })}

                                    {props.data.data.length == 0 && (
                                        <tr>
                                            <td
                                                colSpan={7}
                                                className="text-center"
                                            >
                                                Data Tidak Ditemukan
                                            </td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>

                            <Pagination
                                totals={props.data.total}
                                className="mt-2"
                                links={props.data.links}
                            />
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
};

export default LaporanMasuk;
