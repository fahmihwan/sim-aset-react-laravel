import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, usePage } from "@inertiajs/inertia-react";
import { useEffect, useState } from "react";
import Chart from "chart.js/auto";
import { Line } from "react-chartjs-2";

export default function Dashboard(props) {
    const { aset_masuk, detail_aset_mutasi, detail_aset_penghapusan } =
        usePage().props;

    let dataAsetMasuk = [];
    let dataAsetMutasi = [];
    let dataAsetPenghapusan = [];

    for (let i = 0; i <= 11; i++) {
        dataAsetMasuk.push(0);
        dataAsetMutasi.push(0);
        dataAsetPenghapusan.push(0);
    }
    detail_aset_mutasi.forEach((e) => {
        dataAsetMutasi[e.bulan - 1] = e.total;
    });

    aset_masuk.forEach((e) => {
        dataAsetMasuk[e.bulan - 1] = e.total;
    });
    detail_aset_penghapusan.forEach((e) => {
        dataAsetPenghapusan[e.bulan - 1] = e.total;
    });

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Dashboard
                </h2>
            }
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="border w-8/12 bg-white p-3">
                        <div>
                            <p className="font-bold">Grafik Transaksi</p>
                        </div>
                        <LineChart
                            dataAsetMasuk={dataAsetMasuk}
                            dataAsetMutasi={dataAsetMutasi}
                            dataAsetPenghapusan={dataAsetPenghapusan}
                        />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

const labels = [
    "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember",
];

const LineChart = ({ dataAsetMasuk, dataAsetMutasi, dataAsetPenghapusan }) => {
    return (
        <div>
            <Line
                data={{
                    labels: labels,
                    datasets: [
                        {
                            label: "Aset Masuk",
                            backgroundColor: "rgb(54,211,153)",
                            borderColor: "rgb(73,211,126)",
                            data: dataAsetMasuk,
                        },
                        {
                            label: "Aset Mutasi",
                            backgroundColor: "rgb(251,189,35)",
                            borderColor: "rgb(251,189,35)",
                            data: dataAsetMutasi,
                        },
                        {
                            label: "Aset Penghapusan",
                            backgroundColor: "rgb(255, 99, 132)",
                            borderColor: "rgb(255, 99, 132)",
                            data: dataAsetPenghapusan,
                        },
                    ],
                }}
            />
        </div>
    );
};
