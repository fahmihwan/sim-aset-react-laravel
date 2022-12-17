import DangerButton from "@/Components/DangerButton";
import InputLabel from "@/Components/InputLabel";
import Pagination from "@/Components/Pagination";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Inertia } from "@inertiajs/inertia";
import { Head, useForm, usePage } from "@inertiajs/inertia-react";
import { Link } from "@inertiajs/inertia-react";

const LaporanMutasi = (props) => {
    const { errors } = usePage().props;

    const { data, setData, get, post } = useForm({
        start_date: "",
        end_date: "",
    });

    const handleChange = (e) => {
        setData(e.target.name, e.target.value);
    };

    const sendPrint = () => {
        post("/laporan/export_pdf_masuk");
    };

    const sendSearch = () => {
        get("");
    };

    const handleSubmit = (e) => {
        e.preventDefault();
    };

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Laporan Aset Mutasi
                </h2>
            }
        >
            <Head title="Aset Masuk" />

            <div className="pt-5 px-8  flex justify-between">
                <div className="flex">
                    <div className="mr-3">
                        <InputLabel forInput="start_date" value="start date" />
                        <input
                            type="date"
                            name="start_date"
                            value={data.start_date}
                            onChange={handleChange}
                            placeholder="Type here"
                            className="input input-bordered w-full max-w-xs"
                        />
                    </div>
                    <div className="mr-3">
                        <InputLabel forInput="end_date" value="end date" />
                        <input
                            type="date"
                            name="end_date"
                            value={data.end_date}
                            onChange={handleChange}
                            placeholder="Type here"
                            className="input input-bordered w-full max-w-xs"
                        />
                    </div>
                    <div className="flex items-end mr-3">
                        <button
                            onClick={sendSearch}
                            className="btn btn-primary"
                        >
                            Cari
                        </button>
                    </div>
                    <div className="flex items-end">
                        <button className="btn btn-primary">Print</button>
                    </div>
                </div>
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
                                            Tanggal
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
                                                    {data.tanggal_mutasi}
                                                </td>
                                                <td className="p-0">
                                                    {data.kode_mutasi}
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
                                                                <td>kondisi</td>
                                                                <td>tujuan</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            {data.detail_aset_mutasis.map(
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
                                                                                    d
                                                                                        .detail_aset
                                                                                        .kode_detail_aset
                                                                                }
                                                                            </td>
                                                                            <td className="p-1 ">
                                                                                {
                                                                                    d
                                                                                        .detail_aset
                                                                                        .aset
                                                                                        .nama
                                                                                }
                                                                            </td>
                                                                            <td className="p-1 ">
                                                                                {
                                                                                    d.kondisi
                                                                                }
                                                                            </td>
                                                                            <td className="p-1 ">
                                                                                {
                                                                                    d
                                                                                        .asal_ruangan
                                                                                        .ruangan
                                                                                }{" "}
                                                                                -{" "}
                                                                                {
                                                                                    d
                                                                                        .tujuan_ruangan
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
                                                colSpan={4}
                                                className="text-center"
                                            >
                                                Data Belum Ada
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

export default LaporanMutasi;
