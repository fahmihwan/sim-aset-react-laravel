import { Inertia } from "@inertiajs/inertia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm, usePage } from "@inertiajs/inertia-react";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import PrimaryButton from "@/Components/PrimaryButton";
import DangerButton from "@/Components/DangerButton";
import { useEffect, useState } from "react";
import { Switch } from "@headlessui/react";
import { Alert } from "@/Components/Alert";

export default function Create(props) {
    const { aset_id, ruangan_id, aset_masuk, detail_aset_masuk, flash, auth } =
        usePage().props;

    const [enabled, setEnabled] = useState(aset_masuk.verifikasi);

    const { data, setData, post, processing, errors, destroy, reset } = useForm(
        {
            kode_detail_aset: "",
            aset_masuk_id: aset_masuk.id,
            aset_id: "",
            ruangan_id: "",
        }
    );

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value);
    };
    const handleSubmit = (e) => {
        e.preventDefault();
        post("/detail_aset");
        setData("kode_detail_aset", "");
    };

    const handleDelete = (id) => {
        confirm("apakah anda yakin ingin menghapus?") &&
            Inertia.delete(`/detail_aset/${id}`);
    };

    const verifyData = () => {
        const bol = aset_masuk.verifikasi ? 0 : 1;
        Inertia.put(`/aset_masuk/${aset_masuk.id}`, {
            verifikasi: bol,
        });
        setEnabled(bol);
    };

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Tambah Aset Masuk
                </h2>
            }
        >
            <Head title="Tambah Ruangan" />
            <div className="pt-5 px-8 flex justify-between">
                {flash.type == "fail" ? (
                    <Alert type={flash.type} message={flash.message} />
                ) : (
                    <div></div>
                )}

                <Link
                    href={route("aset_masuk.index")}
                    className="btn btn-sm bg-neutral "
                >
                    Kembali
                </Link>
            </div>

            <div className="py-5">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 md:flex">
                    {/* SINI */}
                    {enabled != true && auth.user.hak_akses == "sarpras" && (
                        <FormAsetMasuk
                            handleSubmit={handleSubmit}
                            data={data}
                            onHandleChange={onHandleChange}
                            props={props}
                            aset_id={aset_id}
                            ruangan_id={ruangan_id}
                            processing={processing}
                        />
                    )}

                    <div
                        className={`w-full  ${
                            enabled != true && auth.user.hak_akses == "sarpras"
                                ? "md:w-4/6"
                                : "md:w-full"
                        }  m-2`}
                    >
                        <div className="bg-white">
                            <div className="p-5 flex">
                                <div className="w-11/12">
                                    {/* Tabel keterangan */}
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>Kode</td>
                                                <td>
                                                    {" "}
                                                    : {aset_masuk.kode_masuk}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td className="pr-3">
                                                    Tanggal Aset Masuk
                                                </td>
                                                <td>
                                                    : {aset_masuk.tanggal_masuk}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>verifikasi</td>
                                                <td>
                                                    :{" "}
                                                    {aset_masuk.verifikasi ? (
                                                        <span className="text-success font-bold">
                                                            sudah
                                                        </span>
                                                    ) : (
                                                        <span className="text-error font-bold">
                                                            belum
                                                        </span>
                                                    )}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Keterangan</td>
                                                <td>
                                                    {" "}
                                                    : {aset_masuk.keterangan}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                {/* is Verify */}
                                {auth.user.hak_akses == "sekertaris" && (
                                    <div className=" w-1/12">
                                        <InputLabel
                                            forInput="Verifikasi"
                                            value="Verifikasi"
                                        />
                                        <Switch
                                            id="Verifikasi"
                                            checked={enabled}
                                            onChange={verifyData}
                                            className={`${
                                                enabled
                                                    ? "bg-blue-600"
                                                    : "bg-gray-200"
                                            } relative inline-flex h-6 w-11 items-center rounded-full`}
                                        >
                                            <span className="sr-only">
                                                Enable notifications
                                            </span>
                                            <span
                                                className={`${
                                                    enabled
                                                        ? "translate-x-6"
                                                        : "translate-x-1"
                                                } inline-block h-4 w-4 transform rounded-full bg-white transition`}
                                            />
                                        </Switch>
                                    </div>
                                )}
                            </div>
                        </div>

                        {/* data detail aset yang di masukan */}
                        <div className="bg-white mt-3 p-3">
                            <p>Detail Aset Masuk</p>
                            <div className="overflow-x-auto">
                                <table className="table w-full">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>kode detail aset</th>
                                            <th>aset</th>
                                            <th>ruangan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {detail_aset_masuk.map((data, i) => {
                                            return (
                                                <tr key={i}>
                                                    <th>{i + 1}</th>
                                                    <td>
                                                        {data.kode_detail_aset}
                                                    </td>
                                                    <td>{data.aset.nama}</td>
                                                    <td>
                                                        {data.ruangan.ruangan}
                                                    </td>
                                                    {enabled ? (
                                                        <td className="text-success text-2xl ">
                                                            <i className="fa-solid fa-circle-check"></i>
                                                        </td>
                                                    ) : (
                                                        <td className="">
                                                            {auth.user
                                                                .hak_akses ==
                                                                "sekertaris" && (
                                                                <td className="text-error text-2xl text-center">
                                                                    <i class="fa-solid fa-circle-xmark"></i>
                                                                </td>
                                                            )}

                                                            {auth.user
                                                                .hak_akses ==
                                                                "sarpras" && (
                                                                <DangerButton
                                                                    onClick={() =>
                                                                        handleDelete(
                                                                            data.id
                                                                        )
                                                                    }
                                                                >
                                                                    <i className="fa-regular fa-trash-can"></i>
                                                                </DangerButton>
                                                            )}
                                                        </td>
                                                    )}
                                                </tr>
                                            );
                                        })}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

const FormAsetMasuk = ({
    handleSubmit,
    data,
    onHandleChange,
    props,
    aset_id,
    ruangan_id,
    processing,
}) => {
    return (
        <div className="bg-white w-full md:w-2/6 shadow-sm sm:rounded-lg m-2">
            <div className="p-5">
                <h1 className="text-2xl mb-3">Form Aset Masuk</h1>

                <form onSubmit={handleSubmit}>
                    <div className="mb-3">
                        <InputLabel
                            forInput="kode_detail_aset"
                            value="kode detail aset"
                        />
                        <TextInput
                            id="kode_detail_aset"
                            type="text"
                            name="kode_detail_aset"
                            value={data.kode_detail_aset}
                            handleChange={onHandleChange}
                            className="mt-1 block w-full"
                            isFocused={true}
                        />
                        <InputError
                            message={props.errors.kode_detail_aset}
                            className="mt-2"
                        />
                    </div>
                    <div className="mb-3">
                        <InputLabel forInput="aset_id" value="Data Aset" />
                        <select
                            className="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                            defaultValue={"DEFAULT"}
                            name="aset_id"
                            id="aset_id"
                            onChange={onHandleChange}
                        >
                            <option value={"DEFAULT"} disabled>
                                pilih aset
                            </option>
                            {aset_id.map((data, i) => {
                                return (
                                    <option key={i} value={data.id}>
                                        {data.nama}
                                    </option>
                                );
                            })}
                        </select>
                        <InputError
                            message={props.errors.aset_id}
                            className="mt-2"
                        />
                    </div>

                    <div className="mb-3">
                        <InputLabel
                            forInput="ruangan_id"
                            value="Data Ruangan"
                        />
                        <select
                            className="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                            defaultValue={"DEFAULT"}
                            name="ruangan_id"
                            id="ruangan_id"
                            onChange={onHandleChange}
                        >
                            <option value={"DEFAULT"} disabled>
                                pilih ruangan
                            </option>
                            {ruangan_id.map((data, i) => {
                                return (
                                    <option key={i} value={data.id}>
                                        {data.ruangan}
                                    </option>
                                );
                            })}
                        </select>
                        <InputError
                            message={props.errors.ruangan_id}
                            className="mt-2"
                        />
                    </div>

                    <PrimaryButton type="submit" disabled={processing}>
                        Submit
                    </PrimaryButton>
                </form>
            </div>
        </div>
    );
};
