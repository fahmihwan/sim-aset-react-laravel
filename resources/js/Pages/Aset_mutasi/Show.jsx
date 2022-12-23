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
    const { aset_mutasi, ruangans, detail_aset_mutasi, flash, auth } =
        usePage().props;

    console.log(flash);
    const [enabled, setEnabled] = useState(aset_mutasi.verifikasi);
    const [detailAset, setDetailAset] = useState([]);
    const [kode, setKode] = useState({
        kode: "",
    });

    const { data, setData, post, processing, errors, destroy, reset } = useForm(
        {
            asal_ruangan_id: "",
            aset_mutasi_id: aset_mutasi.id,
            detail_aset_id: "",
            kondisi: "",
        }
    );
    console.log(data);

    useEffect(() => {
        if (data.asal_ruangan_id != false) {
            fetch(`/get_detail_aset/aset_mutasi/${data.asal_ruangan_id}`)
                .then((res) => res.json())
                .then((res) => {
                    setDetailAset(res);
                });
        }
    }, [data.asal_ruangan_id]);

    const handleChooseKode = (id, kode) => {
        setData("detail_aset_id", id);
        setKode({
            kode: kode,
        });
    };

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value);
        if (e.target.name == "asal_ruangan_id") {
            setKode({
                kode: "",
                ruangan: "",
            });
        }
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post("/detail_aset_mutasi");
        setKode({
            kode: "",
        });
        setData("detail_aset_id", "");
        setData("kondisi", "");
    };

    const handleDelete = (id) => {
        confirm("apakah anda yakin ingin menghapus?") &&
            Inertia.delete(`/detail_aset_mutasi/${id}`);
    };

    const verifyData = () => {
        const bol = aset_mutasi.verifikasi ? 0 : 1;
        Inertia.put(`/aset_mutasi/${aset_mutasi.id}`, {
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
                    Tambah Aset Mutasi
                </h2>
            }
        >
            <Head title="Tambah Ruangan " />
            <div className="pt-5 px-8 flex justify-between">
                {flash.type == "fail" ? (
                    <Alert type={flash.type} message={flash.message} />
                ) : (
                    <div></div>
                )}

                <Link
                    href={route("aset_mutasi.index")}
                    className="btn btn-sm bg-neutral "
                >
                    Kembali
                </Link>
            </div>

            <div className="py-5">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 md:flex">
                    {/* FORM */}
                    {enabled != true && auth.user.hak_akses == "sarpras" && (
                        <FormAsetMutasi
                            handleSubmit={handleSubmit}
                            onHandleChange={onHandleChange}
                            ruangans={ruangans}
                            props={props}
                            kode={kode}
                            detailAset={detailAset}
                            handleChooseKode={handleChooseKode}
                            setData={setData}
                            data={data}
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
                                    <KeteranganEl asetMutasi={aset_mutasi} />
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
                            <p>Detail Aset Mutasi</p>
                            <div className="overflow-x-auto">
                                <TabelDetailAset
                                    detailAsetMutasi={detail_aset_mutasi}
                                    funcHandleDelete={handleDelete}
                                    enabled={enabled}
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

const FormAsetMutasi = ({
    handleSubmit,
    onHandleChange,
    ruangans,
    props,
    kode,
    detailAset,
    handleChooseKode,
    setData,
    data,
}) => {
    return (
        <div className="bg-white w-full md:w-2/6 shadow-sm sm:rounded-lg m-2">
            <div className="p-5">
                <h1 className="text-2xl mb-3">Form Aset Mutasi</h1>
                <form onSubmit={handleSubmit}>
                    {/* ASAL RUANGAN */}
                    <div className="mb-3">
                        <InputLabel
                            forInput="asal_ruangan_id"
                            value="Asal Ruangan"
                        />
                        <select
                            className="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                            defaultValue={"DEFAULT"}
                            name="asal_ruangan_id"
                            id="asal_ruangan_id"
                            onChange={onHandleChange}
                        >
                            <option value={"DEFAULT"} disabled>
                                pilih ruangan
                            </option>
                            {ruangans.map((data, i) => {
                                return (
                                    <option key={i} value={data.id}>
                                        {data.ruangan}
                                    </option>
                                );
                            })}
                        </select>
                        <InputError
                            message={props.errors.asal_ruangan_id}
                            className="mt-2"
                        />
                    </div>

                    {/* KODE DETAIL ASET*/}
                    <div className="mb-3">
                        <InputLabel
                            forInput="kode_detail_aset"
                            value="Kode detail aset"
                        />
                        <div className="flex w-full">
                            <TextInput
                                id="kode_detail_aset"
                                type="text"
                                value={kode.kode}
                                className="block w-full lg:w-72 h-full rounded-r-none bg-gray-100"
                                readonly={true}
                            />
                            <label
                                htmlFor="my-modal-5"
                                className="btn rounded-l-none w-20"
                            >
                                Cari
                            </label>
                        </div>
                        <InputError
                            message={props.errors.detail_aset_id}
                            className="mt-2"
                        />
                    </div>
                    {/* MODAL */}
                    <div className="mb-3">
                        <ModalData
                            detailAset={detailAset ? detailAset : 0}
                            funcChoose={handleChooseKode}
                        />
                    </div>

                    {/* TUJUAN RUANGAN  */}
                    <div className="mb-3">
                        <InputLabel
                            forInput="tujuan_ruangan_id"
                            value="Tujuan Ruangan"
                        />
                        <select
                            className="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                            defaultValue={"DEFAULT"}
                            name="tujuan_ruangan_id"
                            id="tujuan_ruangan_id"
                            onChange={onHandleChange}
                        >
                            <option value={"DEFAULT"} disabled>
                                pilih tujuan ruangan
                            </option>
                            {ruangans.map((data, i) => {
                                return (
                                    <option key={i} value={data.id}>
                                        {data.ruangan}
                                    </option>
                                );
                            })}
                        </select>
                        <InputError
                            message={props.errors.tujuan_ruangan_id}
                            className="mt-2"
                        />
                    </div>

                    {/* KONDISI */}
                    <div className="mb-3">
                        <InputLabel forInput="kondisi" value="Kondisi" />
                        <KondisiEl
                            funcHandleChange={(e) =>
                                setData("kondisi", e.target.value)
                            }
                            dataKondisi={data.kondisi}
                        />
                        <InputError
                            message={props.errors.kondisi}
                            className="mt-2"
                        />
                    </div>
                    <PrimaryButton type="submit">Submit</PrimaryButton>
                </form>
            </div>
        </div>
    );
};

const TabelDetailAset = ({ detailAsetMutasi, funcHandleDelete, enabled }) => {
    return (
        <table className="table w-full">
            <thead>
                <tr>
                    <th>no</th>
                    <th>kode detail aset</th>
                    <th>aset</th>
                    <th>asal ruangan</th>
                    <th>tujuan ruangan</th>
                    <th>kondisi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                {detailAsetMutasi.map((data, i) => {
                    return (
                        <tr key={i}>
                            <th>{i + 1}</th>
                            <td>{data.detail_aset.kode_detail_aset}</td>
                            <td>{data.detail_aset.aset.nama}</td>
                            <td>{data.asal_ruangan.ruangan}</td>
                            <td>{data.tujuan_ruangan.ruangan}</td>
                            <td>{data.kondisi}</td>
                            {enabled ? (
                                <td className="text-success text-2xl text-center">
                                    <i className="fa-solid fa-circle-check"></i>
                                </td>
                            ) : (
                                <td className="text-center">
                                    <DangerButton
                                        onClick={() =>
                                            funcHandleDelete(data.id)
                                        }
                                    >
                                        <i className="fa-regular fa-trash-can"></i>
                                    </DangerButton>
                                </td>
                            )}
                        </tr>
                    );
                })}
            </tbody>
        </table>
    );
};

const KeteranganEl = ({ asetMutasi }) => {
    return (
        <>
            <table>
                <tbody>
                    <tr>
                        <td>Kode</td>
                        <td> : {asetMutasi.kode_mutasi}</td>
                    </tr>
                    <tr>
                        <td className="pr-3">Tanggal Aset Masuk</td>
                        <td>: {asetMutasi.tanggal_mutasi}</td>
                    </tr>
                    <tr>
                        <td>verifikasi</td>
                        <td>
                            :{" "}
                            {asetMutasi.verifikasi ? (
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
                        <td> : {asetMutasi.keterangan}</td>
                    </tr>
                </tbody>
            </table>
        </>
    );
};

const KondisiEl = ({ funcHandleChange, dataKondisi }) => {
    return (
        <div>
            <label className="cursor-pointer mr-3 ">
                <input
                    type="radio"
                    name="kodisi"
                    className="radio checked:bg-blue-500 mr-1"
                    onChange={funcHandleChange}
                    checked={dataKondisi == "bagus"}
                    value="bagus"
                />
                <span className="label-text">Bagus</span>
            </label>
            <label className="cursor-pointer mr-3 ">
                <input
                    type="radio"
                    name="kodisi"
                    className="radio checked:bg-blue-500 mr-1"
                    onChange={funcHandleChange}
                    checked={dataKondisi == "layak"}
                    value="layak"
                />
                <span className="label-text">Layak</span>
            </label>
            <label className="cursor-pointer  ">
                <input
                    type="radio"
                    name="kodisi"
                    className="radio checked:bg-blue-500 mr-1"
                    onChange={funcHandleChange}
                    checked={dataKondisi == "buruk"}
                    value="buruk"
                />
                <span className="label-text">Buruk</span>
            </label>
        </div>
    );
};

const ModalData = ({ detailAset, funcChoose }) => {
    const [search, setSearch] = useState("");

    const resultData = detailAset.filter((data) => {
        if (search == "") {
            return data;
        } else if (
            data.kode_detail_aset.toLowerCase().includes(search.toLowerCase())
        ) {
            return data;
        }
    });

    return (
        <>
            <input type="checkbox" id="my-modal-5" className="modal-toggle" />
            <div className="modal">
                <div className="modal-box w-11/12 max-w-5xl">
                    <h3 className="font-bold text-lg">Detail Aset</h3>
                    <label
                        htmlFor="my-modal-5"
                        className="btn btn-sm btn-circle absolute right-3 top-3"
                    >
                        ✕
                    </label>
                    <TextInput
                        id="cari_data"
                        type="text"
                        className="h-full mb-3  "
                        isFocused={true}
                        value={search}
                        handleChange={(e) => setSearch(e.target.value)}
                        autoComplete="off"
                        placeholder="cari kode"
                    />
                    <div className="overflow-scroll h-96">
                        <table className="table w-full">
                            <thead>
                                <tr>
                                    <td></td>
                                    <th>Kode </th>
                                    <th>Aset</th>
                                    <th>asal ruangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                {resultData != false ? (
                                    resultData.map((data, i) => {
                                        return (
                                            <tr key={i}>
                                                <td>{i + 1}</td>
                                                <td>
                                                    <label
                                                        onClick={() =>
                                                            funcChoose(
                                                                data.id,
                                                                data.kode_detail_aset,
                                                                data.ruangan_id,
                                                                data.ruangan
                                                                    .ruangan
                                                            )
                                                        }
                                                        htmlFor="my-modal-5"
                                                        className="btn btn-sm"
                                                    >
                                                        {data.kode_detail_aset}
                                                    </label>
                                                </td>
                                                <td>{data.aset.nama}</td>
                                                <td>{data.ruangan.ruangan}</td>
                                            </tr>
                                        );
                                    })
                                ) : (
                                    <tr>
                                        <td colSpan={4} className="text-center">
                                            Data Tidak Ditemukan
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </>
    );
};
